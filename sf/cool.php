<?php
// Dummy lead details
$leadData = [
    'name' => 'Abhishek Tiwari',
    'email' => 'abhishek.tiwari@test.com',
    'phone' => '9876543210',
    'city' => 'Hyderabad',
    'enquired_for_program' => 'MBA', 
    'recommended_source' => 'vidya_vriddhi',
    'college_id' => '6533'
];

$jsonData = json_encode($leadData);

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.in6.nopaperforms.com/dataporting/6533/vidya_vriddhi");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData),
    'secret-key: 955e8fa45c82490a82901a536478e379'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute API call
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Decode response
$responseDecoded = json_decode($response, true);

// Display result
echo "<h2>🚀 Submitting Dummy Lead</h2>";

if ($httpCode === 200 && isset($responseDecoded['status'])) {
    if ($responseDecoded['status'] === 'success') {
        echo "<p>✅ Lead Submitted Successfully!</p>";
        echo "<p><strong>Lead ID:</strong> " . ($responseDecoded['data']['lead_id'] ?? 'N/A') . "</p>";
    } elseif (isset($responseDecoded['message']) && stripos($responseDecoded['message'], 'duplicate') !== false) {
        echo "<p>🔁 Duplicate Lead: " . $responseDecoded['message'] . "</p>";
    } else {
        echo "<p>❌ Error: " . ($responseDecoded['message'] ?? 'Unknown error') . "</p>";
    }
} else {
    echo "<p>❌ API Error: " . htmlspecialchars($response) . "</p>";
}
?>
