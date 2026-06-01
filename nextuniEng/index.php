<?php
// ================= CONFIG =================
$apiUrl = "https://nextuni.in/api/agency/leads";
$apiKey = "1eefe42772ba4f5781baed6225a08a69dbcce9b617451af5";

$csvFile = __DIR__ . '/leads.csv';
$run = ($_SERVER['REQUEST_METHOD'] === 'POST');

$total = $success = $failed = 0;
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
            $phone,
            $city,
            $state,
            $course,
            $neetScore, // 👈 yahi JEE score hoga
    $neetRank,  // 👈 yahi JEE rank hoga
            $resultStatus,
            $budget,
            $department,
            $category,
            $source
        ] = $row;

        // ✅ ENGINEERING VALUE ADJUSTMENT
        $course = $course ?: "B.Tech";
        $resultStatus = $resultStatus ?: "12th Passed";
        $department = "Engineering";
        $category = $category ?: "JEE";

        // ===== JSON PAYLOAD =====
        $payload = [
            "name" => trim($name),
            "email" => trim($email),
            "phone" => trim($phone),
            "city" => trim($city),
            "state" => trim($state),
            "course" => trim($course),
            "neetScore" => trim($neetScore),
            "neetRank" => trim($neetRank),
            "resultStatus" => trim($resultStatus),
            "budget" => trim($budget),
            "department" => trim($department),
            "category" => trim($category),
            "source" => trim($source)
        ];

        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "x-api-key: $apiKey"
            ],
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (!curl_errno($ch) && ($httpCode == 200 || $httpCode == 201)) {
            $success++;
            $logs[] = "✅ {$phone} uploaded";
        } else {
            $failed++;
            $error = curl_error($ch) ?: $response;
            $logs[] = "❌ {$phone} failed → {$error}";
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
    <title>Lead Upload System</title>
    <style>
        body { font-family: Arial; background:#f4f6f8; padding:40px }
        .card { background:#fff; max-width:800px; padding:30px; border-radius:10px }
        button { background:#007bff; color:#fff; padding:12px 20px; border:none; border-radius:6px }
        .log { background:#000; color:#0f0; padding:15px; max-height:300px; overflow:auto; margin-top:20px }
    </style>
</head>

<body>

<h2>🚀 Bulk Lead Upload (Engineering - NextUni API)</h2>

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