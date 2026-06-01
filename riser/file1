<?php

// ================= CONFIG =================
$apiUrl     = "https://api.in4.nopaperforms.com/dataporting/6957/tiwari";
$secret_key = "3ab0c814febd409e96c4d591097fa798";
$source     = "tiwari";
$college_id = "6957";

$csvFile = __DIR__ . '/leads.csv';

$run = ($_SERVER['REQUEST_METHOD'] === 'POST');

$total = $success = $failed = 0;
$logs = [];

if ($run) {

    if (!file_exists($csvFile)) {
        die("❌ leads.csv not found in server folder");
    }

    set_time_limit(0);

    $file = fopen($csvFile, 'r');

    // Skip CSV header
    fgetcsv($file);

    while (($row = fgetcsv($file)) !== false) {

        $total++;

        // ensure 7 columns
        $row = array_pad($row, 7, "");

    $row = array_pad($row, 8, "");

list(
    $preferred_stream,
    $course,
    $name,
    $mobile,
    $city,
    $state,
    $exam,
    $center
) = array_map('trim', $row);

        // ================= VALIDATION =================

        if (!$name || !$mobile) {
            $failed++;
            $logs[] = "❌ Row {$total}: Missing Name or Mobile";
            continue;
        }

        if (!preg_match('/^[6-9]\d{9}$/', $mobile)) {
            $failed++;
            $logs[] = "❌ Invalid mobile: {$mobile}";
            continue;
        }

        // ================= PAYLOAD =================
$email = $mobile . "@studyriser.in";
      $payload = [
    "name"       => $name,
    "email"      => $email,
    "mobile"     => $mobile,
    "state"      => $state,
    "city"       => $city,

    "course"     => $course,
    "stream"     => $preferred_stream,

    "medium"     => "CSV Upload",
    "campaign"   => "Studyriser Bulk Upload",

    "secret_key" => $secret_key,
    "source"     => $source,
    "college_id" => $college_id
];

        $ch = curl_init($apiUrl);

        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 20
        ]);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        $code     = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $json = json_decode($response, true);

        if ($code === 200 && ($json['status'] ?? '') === 'Success') {

            $success++;
            $logs[] = "✅ {$mobile} uploaded";

        } else {

            $failed++;
            $logs[] = "❌ {$mobile} failed - " . ($json['message'] ?? $error ?? 'Unknown error');

        }
    }

    fclose($file);
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Studyriser Bulk Lead Upload</title>

<style>

body{
font-family:Arial;
background:#f4f6f8;
padding:40px
}

.card{
background:#fff;
max-width:720px;
padding:30px;
border-radius:10px;
box-shadow:0 6px 20px rgba(0,0,0,.08)
}

button{
background:#2b7cff;
color:#fff;
border:none;
padding:14px 20px;
font-size:16px;
border-radius:8px;
cursor:pointer;
width:100%;
}

input{
width:100%;
padding:10px;
margin-bottom:15px;
}

.stats{
display:flex;
gap:15px;
margin-top:20px;
}

.stat{
flex:1;
background:#f9fafb;
padding:15px;
border-radius:8px;
text-align:center;
font-size:15px;
}

.success{color:green;font-weight:bold}
.fail{color:red;font-weight:bold}

.log{
margin-top:25px;
background:#111;
color:#0f0;
padding:15px;
font-family:monospace;
max-height:300px;
overflow:auto;
border-radius:6px;
}

.summary{
margin-top:20px;
background:#eef6ff;
padding:15px;
border-radius:8px;
font-size:14px;
}

</style>

</head>

<body>

<h2>🚀 Studyriser – Bulk CSV Lead Upload</h2>

<div class="card">
<form method="post">
    <p><b>Source:</b> leads.csv (server file)</p>
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
• College ID: <?= $college_id ?><br>
• Source: <?= $source ?><br>
• Mode: CSV Bulk Upload

</div>

<?php endif; ?>

</div>

</body>
</html>