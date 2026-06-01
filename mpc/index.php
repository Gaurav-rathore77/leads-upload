<?php
$data = [
    'name' => 'Test Shyam',
    'email' => 'sh7am@meritto.com',
    'mobile' => '9997889990',
    'state' => 'Haryana',
    'city' => 'Gurugram',
    'course' => 'B.TECH',
    'specialization' => 'B.Tech CSE',
    'secret_key' => 'ece7482511217f1e38e9561ecf658271',
    'source' => 'vidyavriddhi',
    'college_id' => '498',
    'medium' => 'test-medium',
    'campaign' => 'test-campaign'
];

$startTime = microtime(true);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.nopaperforms.com/dataporting/498/vidyavriddhi");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
$response = curl_exec($ch);
$endTime = microtime(true);
$duration = round($endTime - $startTime, 3) . 's';
echo "<h3>Lead Submission Result</h3>";
if (curl_errno($ch)) {
    echo "<strong>Error:</strong> " . curl_error($ch) . "<br>";
    echo "<strong>Time taken:</strong> $duration<br>";
} else {
    $decoded = json_decode($response, true);
    echo "<strong>Response:</strong><br><pre>" . htmlspecialchars($response) . "</pre>";
    echo "<strong>Status:</strong> " . ($decoded['status'] ?? 'Unknown') . "<br>";
    echo "<strong>Time taken:</strong> $duration<br>";
}

curl_close($ch);
?>
