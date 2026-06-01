<?php
// ================= CONFIG =================
$apiUrl = "https://api.nopaperforms.com/dataporting/4038/vidhyavridhi";

$secretKey = "9d38be9cd815339e7dd0341fd258888e";
$source    = "vidhyavridhi";
$collegeId = "4038";

$csvFile = __DIR__ . '/leads.csv';
$run = ($_SERVER['REQUEST_METHOD'] === 'POST');

$total = $success = $failed = 0;
$failReasons = [];
$logs = [];

if ($run) {

    if (!file_exists($csvFile)) {
        die("❌ leads.csv not found");
    }

    set_time_limit(0);

    $file = fopen($csvFile, 'r');
    fgetcsv($file); // skip header

    while (($row = fgetcsv($file)) !== false) {

        $total++;

        [
            $name,
            $email,
            $mobile,
            $state,
            $city,
            $course,
            $specialization,
            $campaign,
            $medium
        ] = $row;

        // ===== PAYLOAD FOR NOPAPERFORMS =====
        $payload = [
            "secret_key"     => $secretKey,
            "source"         => $source,
            "college_id"     => $collegeId,

            "name"           => trim($name),
            "email"          => trim($email),
            "mobile"         => trim($mobile),
            "state"          => trim($state),
            "city"           => trim($city),

            "course"         => trim($course),          // UG / PG / Diploma etc
            "specialization" => trim($specialization),  // MBBS, B.Tech etc

            "campaign"       => trim($campaign),
            "medium"         => trim($medium)
        ];

        $ch = curl_init($apiUrl);

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POSTFIELDS => http_build_query($payload) // IMPORTANT
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (!curl_errno($ch) && $httpCode == 200) {
            $success++;
            $logs[] = "✅ {$mobile} uploaded";
        } else {
            $failed++;
            $reason = curl_error($ch) ?: "API Error";
            $failReasons[$reason] = ($failReasons[$reason] ?? 0) + 1;
            $logs[] = "❌ {$mobile} failed → {$reason}";
        }

        curl_close($ch);
        flush();
        ob_flush();
    }

    fclose($file);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>NoPaperForms Upload</title>
    <style>
        body { font-family: Arial; background:#f4f6f8; padding:40px }
        .card { background:#fff; max-width:800px; padding:30px; border-radius:10px }
        button { background:#28a745; color:#fff; padding:12px 20px; border:none; border-radius:6px }
        .log { background:#000; color:#0f0; padding:15px; max-height:300px; overflow:auto; margin-top:20px }
    </style>
</head>

<body>

<h2>🚀 NoPaperForms Lead Upload</h2>

<div class="card">

<form method="post">
    <button type="submit">▶ Start Upload</button>
</form>

<?php if ($run): ?>

<p>Total: <?= $total ?> | ✅ Success: <?= $success ?> | ❌ Failed: <?= $failed ?></p>

<div class="log">
<?php foreach ($logs as $log): ?>
    <?= htmlspecialchars($log) ?><br>
<?php endforeach; ?>
</div>

<?php endif; ?>

</div>
</body>
</html>