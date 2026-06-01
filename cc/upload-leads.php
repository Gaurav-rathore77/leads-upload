<?php
// ================= CONFIG =================
$apiUrl = "https://api.in5.nopaperforms.com/dataporting/5645/vidyavriddhi";
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
            $budget,
            $csvCourse,
            $name,
            $mobile,
            $email,
            $city,
            $state
        ] = $row;

        $data = [
            'name'           => trim($name),
            'email'          => trim($email),
            'mobile'         => trim($mobile),
            'state'          => trim($state),
            'city'           => trim($city),
            'course'         => 'PG',
            'specialization' => 'MBA/PGDM',
            'secret_key'     => 'cab4bdbdfcf9c031ab5e899d5de01042',
            'source'         => 'vidyavriddhi',
            'college_id'     => '5645'
        ];

        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 20
        ]);

        $response = curl_exec($ch);

        if (!curl_errno($ch)) {
            $decoded = json_decode($response, true);

            if (($decoded['status'] ?? '') === 'Success') {
                $success++;
                $logs[] = "✅ {$mobile} uploaded successfully";
            } else {
                $failed++;
                $logs[] = "❌ {$mobile} - " . ($decoded['message'] ?? 'API error');
            }
        } else {
            $failed++;
            $logs[] = "❌ {$mobile} - CURL: " . curl_error($ch);
        }

        curl_close($ch);
    }

    fclose($file);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CSV Upload Engine</title>
    <style>
        body { font-family: Arial; background:#f4f6f8; padding:40px }
        .card {
            background:#fff; max-width:700px; padding:30px;
            border-radius:10px; box-shadow:0 6px 20px rgba(0,0,0,.08)
        }
        button {
            background:#2b7cff; color:#fff; border:none;
            padding:14px 20px; font-size:16px;
            border-radius:8px; cursor:pointer;
        }
        .stats {
            display:flex; gap:15px; margin-top:20px;
        }
        .stat {
            flex:1; background:#f9fafb; padding:15px;
            border-radius:8px; text-align:center;
        }
        .success { color:green; font-weight:bold }
        .fail { color:red; font-weight:bold }
        .log {
            margin-top:25px; background:#111; color:#0f0;
            padding:15px; font-family:monospace;
            max-height:260px; overflow:auto;
            border-radius:6px;
        }
        .summary {
            margin-top:20px; background:#eef6ff;
            padding:15px; border-radius:8px;
        }
    </style>
</head>
<body>

<h2>🚀 CSV Upload Engine</h2>

<div class="card">

    <form method="post">
        <button type="submit">▶ Start Upload Engine</button>
    </form>

    <?php if ($run): ?>
        <div class="stats">
            <div class="stat">
                <b>Total</b><br><?= $total ?>
            </div>
            <div class="stat success">
                Uploaded<br><?= $success ?>
            </div>
            <div class="stat fail">
                Failed<br><?= $failed ?>
            </div>
        </div>

        <div class="log">
            <?php foreach ($logs as $log): ?>
                <?= htmlspecialchars($log) ?><br>
            <?php endforeach; ?>
        </div>

        <div class="summary">
            <b>Summary</b><br>
            • Total Leads: <?= $total ?><br>
            • Successfully Uploaded: <?= $success ?><br>
            • Failed: <?= $failed ?><br>
            • Course Sent: <b>PG</b><br>
            • Specialization Sent: <b>MBA/PGDM</b>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
