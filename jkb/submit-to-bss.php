<?php
include '../config.php';

$sql = "SELECT id, name, email, mobile, state, city, program, course FROM jkb";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
    exit;
}

if ($result->num_rows > 0) {
    $errors = [];
    $successCount = 0;

    while ($row = $result->fetch_assoc()) {
        $data = [
            'AuthToken' => 'bssfoundation_14-10-2024',
            'Source' => 'bssfoundation',
            'FirstName' => $row['name'],
            'Email' => $row['email'],
            'MobileNumber' => $row['mobile'],
            'LeadSource' => 63,
            'leadChannel' => 2,
            'Course' => 1,
            'Center' => 1
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://thirdpartyapi.extraaedge.com/api/SaveRequest");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $successCount++;
        } else {
            $errors[] = "ID {$row['id']} - API Error: " . ($response ?: "Unknown Error");
        }
    }

    echo "$successCount records submitted successfully.";
    if (!empty($errors)) {
        echo "<br>Errors:<br>" . implode("<br>", $errors);
    }
} else {
    echo "No records to submit.";
}

$conn->close();
?>