```php
<?php
$apiUrl = "https://api.nopaperforms.com/dataporting/4038/vidhyavridhi";
$secret_key = "9d38be9cd815339e7dd0341fd258888e";
$source = "vidhyavridhi";
$college_id = "4038";

$csvFile = __DIR__ . '/leads.csv';

$results = [];

// Counters
$totalLeads = 0;
$successLeads = 0;
$failedLeads = 0;

/**
 * Course Mapping Function
 */
function mapCourse($courseRaw) {
    $courseRaw = strtolower(trim($courseRaw));

    $map = [
        'mba'   => ['course' => 'PG', 'specialization' => 'MBA'],
        'mca'   => ['course' => 'PG', 'specialization' => 'MCA'],
        'mtech' => ['course' => 'PG', 'specialization' => 'M.Tech'],
        'btech' => ['course' => 'UG', 'specialization' => 'B.Tech'],
        'bba'   => ['course' => 'UG', 'specialization' => 'BBA'],
        'bca'   => ['course' => 'UG', 'specialization' => 'BCA'],
        'bcom'  => ['course' => 'UG', 'specialization' => 'B.Com'],
        'mbbs'  => ['course' => 'UG', 'specialization' => 'MBBS'],
        'bds'   => ['course' => 'UG', 'specialization' => 'BDS'],
    ];

    return $map[$courseRaw] ?? ['course' => 'Other', 'specialization' => 'Other'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!file_exists($csvFile)) {
        die("leads.csv file not found");
    }

    set_time_limit(0);

    $file = fopen($csvFile, 'r');

    // skip header
    $header = fgetcsv($file);

    while (($row = fgetcsv($file)) !== false) {

        $totalLeads++; //  count total

        $name      = $row[0] ?? '';
        $email     = $row[1] ?? '';
        $mobile    = $row[2] ?? '';
        $state     = $row[3] ?? '';
        $city      = $row[4] ?? '';
        $courseRaw = $row[5] ?? '';

        // CLEAN MOBILE
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        $mobile = substr($mobile, -10);

        // VALIDATE EMAIL
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $failedLeads++; // ❌ fail count

            $results[] = [
                'name'   => $name,
                'mobile' => $mobile,
                'status' => 'Fail',
                'msg'    => 'Invalid email format (skipped)'
            ];
            continue;
        }

        $courseData = mapCourse($courseRaw);

        $payload = [
            "name"           => trim($name),
            "email"          => trim($email),
            "mobile"         => $mobile,
            "state"          => trim($state),
            "city"           => trim($city),
            "course"         => $courseData['course'],
            "specialization" => $courseData['specialization'],
            "medium"         => "Online",
            "campaign"       => "CSV Upload",
            "secret_key"     => $secret_key,
            "source"         => $source,
            "college_id"     => $college_id
        ];

        $ch = curl_init($apiUrl);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_TIMEOUT        => 20
        ]);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        $code     = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $json = json_decode($response, true);

        $status = ($code == 200 && ($json['status'] ?? '') === 'Success') ? 'Success' : 'Fail';

        // success/fail count
        if ($status === 'Success') {
            $successLeads++;
        } else {
            $failedLeads++;
        }

        $results[] = [
            'name'   => $name,
            'mobile' => $mobile,
            'status' => $status,
            'msg'    => $json['message'] ?? $error ?? 'Unknown error'
        ];
    }

    fclose($file);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>🚀 CSV Lead Upload</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
            padding: 40px;
        }
        .card {
            background: #fff;
            max-width: 500px;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0,0,0,.08);
        }
        button {
            width: 100%;
            padding: 14px;
            background: #2b7cff;
            color: #fff;
            border: none;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #1a5fd1;
        }
        table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #f0f2f5;
        }
        .ok {
            color: green;
            font-weight: bold;
        }
        .fail {
            color: red;
            font-weight: bold;
        }
        .stats {
            margin-top: 20px;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            font-size: 16px;
        }
    </style>
</head>

<body>

<h2>🚀 CSV Lead Upload</h2>

<div class="card">
    <form method="post">
        <p><b>CSV Format:</b> name,email,mobile,state,city,course</p>
        <p><b>File:</b> leads.csv (same folder)</p>
        <button type="submit">Run Upload</button>
    </form>
</div>

<?php if (!empty($results)): ?>

    <!-- ✅ COUNTER UI -->
    <div class="stats">
        <b>Total Leads:</b> <?= $totalLeads ?> <br><br>
        <b style="color:green;">Success:</b> <?= $successLeads ?> <br><br>
        <b style="color:red;">Failed:</b> <?= $failedLeads ?>
    </div>

    <table>
        <tr>
            <th>Name</th>
            <th>Mobile</th>
            <th>Status</th>
            <th>Message</th>
        </tr>
        <?php foreach ($results as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['name']) ?></td>
                <td><?= htmlspecialchars($r['mobile']) ?></td>
                <td class="<?= $r['status'] == 'Success' ? 'ok' : 'fail' ?>">
                    <?= $r['status'] ?>
                </td>
                <td><?= htmlspecialchars($r['msg']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php endif; ?>

</body>
</html>
```
