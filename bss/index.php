<?php
// ================= CONFIG =================
$apiUrl = "https://publisher.extraaedge.com/api/Webhook/addPublisherLead";
$authToken = "bssfoundation_14-10-2024";
$source    = "bssfoundation";
$leadSourceId = 114;

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
            $courseId,
            $centerId,
            $campaign
        ] = $row;

        // ===== PAYLOAD AS PER EXTRAAEDGE FORMAT =====
        $payload = [
            "AuthToken"     => $authToken,
            "Source"        => $source,
            "FirstName"     => trim($name),
            "MobileNumber"  => trim($mobile),
            "Email"         => trim($email),
            "Course"        => (int)$courseId,
            "Center"        => (int)$centerId,
            "LeadSource"    => $leadSourceId,
            "leadCampaign" => trim($campaign)
        ];

        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTPHEADER     => [
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload)
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $decoded  = json_decode($response, true);

        if (!curl_errno($ch) && $httpCode === 200) {
            $success++;
            $logs[] = "✅ {$mobile} uploaded successfully";
        } else {
            $failed++;
            $reason = $decoded['Message'] ?? $decoded['message'] ?? 'Unknown API error';
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
    <title>ExtraaEdge Lead Upload</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
            padding: 40px
        }

        .card {
            background: #fff;
            max-width: 800px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .08)
        }

        button {
            background: #0066cc;
            color: #fff;
            border: none;
            padding: 14px 22px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
        }

        .stats {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .stat {
            flex: 1;
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .success {
            color: green;
            font-weight: bold
        }

        .fail {
            color: red;
            font-weight: bold
        }

        .log {
            margin-top: 25px;
            background: #111;
            color: #0f0;
            padding: 15px;
            font-family: monospace;
            max-height: 300px;
            overflow: auto;
            border-radius: 6px;
        }

        .summary {
            margin-top: 20px;
            background: #eef6ff;
            padding: 15px;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <h2>🚀 ExtraaEdge Leads Upload</h2>

    <div class="card">

        <form method="post">
            <button type="submit">▶ Start Upload</button>
        </form>

        <?php if ($run): ?>

            <div class="stats">
                <div class="stat">
                    <b>Total Leads</b><br><?= $total ?>
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
                <b>Main Failure Reasons</b><br>
                <?php if ($failed): ?>
                    <?php foreach ($failReasons as $reason => $count): ?>
                        • <?= htmlspecialchars($reason) ?> — <?= $count ?><br>
                    <?php endforeach; ?>
                <?php else: ?>
                    No failures 🎉
                <?php endif; ?>
            </div>

        <?php endif; ?>

    </div>

</body>

</html>