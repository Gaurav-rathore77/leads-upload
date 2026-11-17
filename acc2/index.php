<?php

// ==========================================
// VIDYA VRIDHI - NOPAPERFORMS API CONFIG
// ==========================================

$apiUrl = "https://api.in4.nopaperforms.com/dataporting/6905/vidya_vridhi";

$secret_key = "PASTE_NEW_SECRET_KEY_HERE";

$source = "vidya_vridhi";
$college_id = "6905";

$csvFile = __DIR__ . '/leads.csv';

// Default values if CSV doesn't contain these columns
$defaultMedium = "Online";
$defaultCampaign = "CSV Upload";

$results = [];

$totalLeads = 0;
$successLeads = 0;
$failedLeads = 0;


// ==========================================
// COURSE MAPPING
// ==========================================

function mapCourse($courseRaw) {

    $courseRaw = strtolower(trim($courseRaw));

    $map = [

        'mba' => 'MBA/PGDM',
        'pgdm' => 'MBA/PGDM',
        'mba/pgdm' => 'MBA/PGDM',

        'bba' => 'BBA',
        'bca' => 'BCA',
        'btech' => 'BTECH',
        'b.tech' => 'BTECH',

        'b.pharma' => 'B. Pharma',
        'b pharma' => 'B. Pharma',
        'bpharma' => 'B. Pharma',

        'm.pharma' => 'M.Pharma',
        'm pharma' => 'M.Pharma',
        'mpharma' => 'M.Pharma',

        'mca' => 'MCA',

        'ba llb' => 'BA LLB',
        'bba llb' => 'BBA LLB',

        'ba.arch' => 'BA.Arch',
        'ba arch' => 'BA.Arch',

        'design' => 'DESIGN courses',
        'design courses' => 'DESIGN courses'
    ];

    return $map[$courseRaw] ?? null;
}


// ==========================================
// CSV UPLOAD PROCESS
// ==========================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!file_exists($csvFile)) {
        die("leads.csv file not found!");
    }

    set_time_limit(0);

    $file = fopen($csvFile, 'r');

    // Read CSV header
    $header = fgetcsv($file);

    if (!$header) {
        die("CSV file is empty!");
    }

    // Normalize headers
    $header = array_map(function($value) {
        return strtolower(trim($value));
    }, $header);

    // Header positions
    $columns = array_flip($header);

    while (($row = fgetcsv($file)) !== false) {

        // Skip completely empty rows
        if (count(array_filter($row, function($v) {
            return trim($v) !== '';
        })) === 0) {
            continue;
        }

        $totalLeads++;

        // Read CSV values by header name
        $name = $row[$columns['name'] ?? -1] ?? '';
        $email = $row[$columns['email'] ?? -1] ?? '';

        $mobile = $row[$columns['mobile'] ?? $columns['phoneno'] ?? -1] ?? '';

        $state = $row[$columns['state'] ?? -1] ?? '';
        $city = $row[$columns['city'] ?? -1] ?? '';

        $courseRaw = $row[$columns['course'] ?? -1] ?? '';

        // Dynamic medium and campaign
        $medium = $row[$columns['medium'] ?? -1] ?? $defaultMedium;

        $campaign = $row[$columns['campaign'] ?? -1] ?? $defaultCampaign;

        // Clean values
        $name = trim($name);
        $email = trim($email);
        $state = trim($state);
        $city = trim($city);

        $medium = trim($medium) ?: $defaultMedium;
        $campaign = trim($campaign) ?: $defaultCampaign;

        // Clean mobile number
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        $mobile = substr($mobile, -10);

        // Validate required fields
        if (
            empty($name) ||
            empty($mobile) ||
            strlen($mobile) !== 10 ||
            !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {

            $failedLeads++;

            $results[] = [
                'name' => $name,
                'mobile' => $mobile,
                'status' => 'Fail',
                'msg' => 'Invalid name, mobile or email'
            ];

            continue;
        }

        // Course mapping
        $course = mapCourse($courseRaw);

        if (!$course) {

            $failedLeads++;

            $results[] = [
                'name' => $name,
                'mobile' => $mobile,
                'status' => 'Fail',
                'msg' => 'Invalid course: ' . $courseRaw
            ];

            continue;
        }


        // ==================================
        // API PAYLOAD
        // ==================================

        $payload = [

            "name" => $name,
            "email" => $email,
            "mobile" => $mobile,

            "state" => $state,
            "city" => $city,

            "course" => $course,

            "medium" => $medium,
            "campaign" => $campaign,

            "secret_key" => $secret_key,
            "source" => $source,
            "college_id" => $college_id
        ];


        // ==================================
        // API REQUEST
        // ==================================

        $ch = curl_init($apiUrl);

        curl_setopt_array($ch, [

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_POST => true,

            CURLOPT_POSTFIELDS => $payload,

            CURLOPT_TIMEOUT => 30,

            CURLOPT_CONNECTTIMEOUT => 10,

            CURLOPT_SSL_VERIFYPEER => true

        ]);

        $response = curl_exec($ch);

        $error = curl_error($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);


        // Decode API response
        $json = json_decode($response, true);


        // Determine status
        $status = (
            $httpCode == 200 &&
            ($json['status'] ?? '') === 'Success'
        ) ? 'Success' : 'Fail';


        if ($status === 'Success') {

            $successLeads++;

        } else {

            $failedLeads++;

        }


        $results[] = [

            'name' => $name,
            'mobile' => $mobile,

            'status' => $status,

            'msg' => $json['message'] ??
                     $error ??
                     ($response ?: 'Unknown API Error')

        ];

    }

    fclose($file);
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Vidya Vridhi - CSV Lead Upload</title>

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
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            font-size: 16px;
        }

    </style>

</head>

<body>

<h2>🚀 Vidya Vridhi - CSV Lead Upload</h2>

<div class="card">

    <form method="post">

        <p><b>CSV Format:</b></p>

        <p>
            name,email,mobile,state,city,course,medium,campaign
        </p>

        <p><b>File:</b> leads.csv (same folder)</p>

        <button type="submit">
            Run Upload
        </button>

    </form>

</div>


<?php if (!empty($results)): ?>

    <div class="stats">

        <b>Total Leads:</b> <?= $totalLeads ?><br><br>

        <b style="color:green;">
            Success: <?= $successLeads ?>
        </b><br><br>

        <b style="color:red;">
            Failed: <?= $failedLeads ?>
        </b>

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
                    <?= htmlspecialchars($r['status']) ?>
                </td>

                <td><?= htmlspecialchars($r['msg']) ?></td>

            </tr>

        <?php endforeach; ?>

    </table>

<?php endif; ?>

</body>
</html>
