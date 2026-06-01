<?php
$leads = [
    [
        'name' => 'Lokesh Agrawal',
        'email' => 'lokeshagrawal23022007@gmail.com',
        'mobile' => '9058764155',
        'city' => 'Lucknow',
        'state' => 'Uttar Pradesh'
    ],
    [
        'name' => 'Anannya Rohilla',
        'email' => 'anannyarohilla12@gmail.com',
        'mobile' => '8126020857',
        'city' => 'Lucknow',
        'state' => 'Uttar Pradesh'
    ],
    // ... add all 43 cleaned leads here in same format
];

$defaults = [
    'course' => 'B.TECH',
    'specialization' => 'B.Tech CSE',
    'secret_key' => 'ece7482511217f1e38e9561ecf658271',
    'source' => 'vidyavriddhi',
    'college_id' => '498',
    'medium' => 'test-medium',
    'campaign' => 'test-campaign'
];

$endpoint = "https://api.nopaperforms.com/dataporting/498/vidyavriddhi";

$totalStart = microtime(true);
echo "<h2>📝 Bulk Lead Submission Status</h2>";

foreach ($leads as $index => $lead) {
    $data = array_merge($lead, $defaults);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $start = microtime(true);
    $response = curl_exec($ch);
    $duration = round(microtime(true) - $start, 2);

    $status = 'Unknown';
    $emoji = '❌';

    if (!curl_errno($ch)) {
        $decoded = json_decode($response, true);
        if (isset($decoded['status']) && strtolower($decoded['status']) === 'success') {
            $status = 'Success';
            $emoji = '✅';
        } elseif (isset($decoded['status'])) {
            $status = $decoded['status'];
        }
    } else {
        $response = curl_error($ch);
    }

    echo "<div style='margin-bottom:10px;'><strong>$emoji Lead " . ($index + 1) . ":</strong> " . htmlspecialchars($lead['name']) . " - <strong>Status:</strong> $status - ⏱️ $duration sec</div>";
    curl_close($ch);
}

$totalDuration = round(microtime(true) - $totalStart, 2);
echo "<hr><h3>⏳ Total Time Taken: <strong>$totalDuration seconds</strong></h3>";
?>
