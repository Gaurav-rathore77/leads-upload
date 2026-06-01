<?php
// Path to your CSV file
$csvFile = 'mpc18june.csv'; // Replace with your CSV file path

// Open the file
if (($handle = fopen($csvFile, "r")) !== false) {
    $header = fgetcsv($handle); // Read header row

    echo "<h3>Lead Submission Results</h3>";

    $rowCount = 0;
    while (($row = fgetcsv($handle)) !== false) {
        $rowCount++;

        // Map header => value
        $lead = array_combine($header, $row);

        // Prepare data for API
        $data = [
            'name' => $lead['full_name'],
            'email' => $lead['email'],
            'mobile' => $lead['mobile'],
            'state' => $lead['state'],
            'city' => $lead['city'],
            'course' => 'B.TECH', // Static, can be made dynamic
            'specialization' => 'B.Tech CSE', // Static, or from CSV
            'secret_key' => 'ece7482511217f1e38e9561ecf658271',
            'source' => 'vidyavriddhi',
            'college_id' => '498',
            'medium' => 'test-medium',
            'campaign' => 'test-campaign'
        ];

        // Send API request
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

        // Show result
        echo "<strong>Lead #$rowCount - {$data['name']}</strong><br>";
        if (curl_errno($ch)) {
            echo "❌ <strong>Error:</strong> " . curl_error($ch) . "<br>";
        } else {
            $decoded = json_decode($response, true);
            echo "✅ <strong>Status:</strong> " . ($decoded['status'] ?? 'Unknown') . "<br>";
            echo "<strong>Response:</strong> <pre>" . htmlspecialchars($response) . "</pre>";
        }
        echo "<strong>Time taken:</strong> $duration<br><hr>";

        curl_close($ch);
    }

    fclose($handle);
} else {
    echo "Failed to open CSV file.";
}
?>
