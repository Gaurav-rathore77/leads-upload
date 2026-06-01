<?php
// Path to the CSV file
$csvFile = 'C:/Users/thesh/Downloads/11aughike.csv';

// Check if file exists
if (!file_exists($csvFile)) {
    die("❌ CSV file not found at: $csvFile");
}

$successCount = 0;
$duplicateCount = 0;
$errorCount = 0;

// Read and parse CSV
$csvData = array_map('str_getcsv', file($csvFile));
array_shift($csvData); // Remove header

echo "<h2>🚀 Submitting Leads from CSV</h2>";

foreach ($csvData as $index => $row) {
    list($program, $full_name, $email, $phone_number, $city) = $row;

    // Clean phone number (remove prefix like "p:")
    $phone_number = trim(str_replace(['p:', '+'], '', $phone_number));

    // Prepare payload
    $data = [
        'name' => $full_name,
        'phone' => $phone_number,
        'email' => $email,
        'mx_City' => $city,
        'Lead_Vendor_Source' => 'Amity',
        'SourceCampaign' => 'Hyderabad',
        'SourceContent' => 'MSG1',
        'SourceMedium' => 'VV',
        'EnquiredforProgram' => $program,
        'EnquiredforCourse' => '',
        'LeadSource' => 'Vidya Vriddhi',
        'utm_adgroup' => '',
        'utm_term' => '',
        'mx_utm_gclid' => '',
        'utm_keyword' => 'vv'
    ];

    $jsonData = json_encode($data);

    // Submit via cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://business-agility-9703.my.salesforce-sites.com/services/apexrest/leadCreationAPI");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $responseDecoded = json_decode($response, true);
    $status = "❌ Error";
    $message = $response;

    if (
        $httpCode === 200 &&
        isset($responseDecoded['success']) &&
        $responseDecoded['success'] === true
    ) {
        if (empty($responseDecoded['errors'])) {
            $successCount++;
            $status = "✅ Submitted";
            $message = "Lead ID: " . $responseDecoded['id'];
        } elseif (in_array("Lead already exists.", $responseDecoded['errors'])) {
            $duplicateCount++;
            $status = "🔁 Duplicate";
            $message = "Lead already exists.";
        } else {
            $errorCount++;
            $status = "❌ Error";
            $message = implode(", ", $responseDecoded['errors']);
        }
    } else {
        $errorCount++;
        $status = "❌ Error";
    }

    // Output result
    echo "<div style='margin-bottom: 10px;'>
        <strong>" . ($index + 1) . ".</strong> $full_name | $email | $phone_number | $city <br>
        <span>Status: <strong>$status</strong></span> — $message
    </div><hr>";
}

// Summary
echo "<h3>✅ Summary:</h3>";
echo "<strong>✅ Successful:</strong> $successCount<br>";
echo "<strong>🔁 Duplicates:</strong> $duplicateCount<br>";
echo "<strong>❌ Errors:</strong> $errorCount<br>";
?>