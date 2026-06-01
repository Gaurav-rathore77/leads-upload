<?php
$apiUrl = "https://api.nopaperforms.com/dataporting/375/vidyavirddhi";
$secret_key = "e1c2e501cb7b5d4ba5f0eef5a7d350d0";
$source = "vidyavirddhi";
$college_id = "375";

// CSV FILE PATH
$csvFile = __DIR__ . '/leads.csv';

$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!file_exists($csvFile)) {
        die("❌ leads.csv not found");
    }

    set_time_limit(0);

    $file = fopen($csvFile, 'r');
    $header = fgetcsv($file); // skip header

    while (($row = fgetcsv($file)) !== false) {

        [$budget, $course, $name, $mobile, $email, $city, $state] = $row;

        $payload = [
            "name"       => trim($name),
            "email"      => trim($email),
            "mobile"     => trim($mobile),
            "state"      => trim($state),
            "city"       => trim($city),
            "course"     => strtoupper(trim($course)),
            "medium"     => "Online",
            "campaign"   => "CSV Server Upload",
            "cf_budget"  => trim($budget),
            "secret_key" => $secret_key,
            "source"     => $source,
            "college_id" => $college_id
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

        $results[] = [
            'name'   => $name,
            'mobile' => $mobile,
            'status' => ($code == 200 && ($json['status'] ?? '') === 'Success') ? 'Success' : 'Fail',
            'msg'   => $json['message'] ?? $error
        ];
    }

    fclose($file);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>CSV Lead Runner</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
            padding: 40px
        }

        .card {
            background: #fff;
            max-width: 460px;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .08)
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

        table {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd
        }

        th {
            background: #f0f2f5
        }

        .ok {
            color: green;
            font-weight: bold
        }

        .fail {
            color: red;
            font-weight: bold
        }
    </style>
</head>

<body>

    <h2>🚀 Server CSV Lead Upload</h2>

    <div class="card">
        <form method="post">
            <p><b>Source:</b> leads.csv (server)</p>
            <button type="submit">Run Upload</button>
        </form>
    </div>

    <?php if (!empty($results)): ?>
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