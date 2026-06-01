<?php
include '../config.php';

$successCount = 0;
$duplicateCount = 0;
$errorCount = 0;

$sql = "SELECT * FROM hkleads WHERE submitted_to_api = 0";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    die("No records to submit.");
}

while ($row = $result->fetch_assoc()) {
    $data = [
        'name' => $row['full_name'],
        'phone' => $row['phone_number'],
        'email' => $row['email'],
        'mx_City' => $row['city'],
        'Lead_Vendor_Source' => 'Amity',
        'SourceCampaign' => 'Hyderabad',
        'SourceContent' => 'MSG1',
        'SourceMedium' => 'VV', // ✅ As requested
        'EnquiredforProgram' => $row['program'],
        'EnquiredforCourse' => '',
        'LeadSource' => 'Vidya Vriddhi',
        'utm_adgroup' => '', // ✅ blank
        'utm_term' => '',     // ✅ blank
        'mx_utm_gclid' => '', // ✅ blank
        'utm_keyword' => 'vv'
    ];

    $jsonData = json_encode($data);

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
    $status = "Error";
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

            // ✅ Mark as submitted in DB
            $update = $conn->prepare("UPDATE hkleads SET submitted_to_api = 1 WHERE id = ?");
            $update->bind_param("i", $row['id']);
            $update->execute();
            $update->close();
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

    // ✅ Line-by-line log
    echo "{$row['id']}. {$row['full_name']} - {$row['email']} - {$status} - {$message}<br>";
}

echo "<hr>";
echo "<strong>✅ Successful:</strong> $successCount<br>";
echo "<strong>🔁 Duplicates:</strong> $duplicateCount<br>";
echo "<strong>❌ Errors:</strong> $errorCount<br>";
?>