<?php
include '../config.php';

// Fetch all entries that are not yet submitted
$sql = "SELECT * FROM enquiries WHERE submitted = 0";
$result = $conn->query($sql);

// Check if query execution was successful
if ($result === false) {
    // If there is a query error, display it
    echo "Error: " . $conn->error;
    exit;
}

if ($result->num_rows > 0) {
    $errors = [];
    $successCount = 0;

    while ($row = $result->fetch_assoc()) {
        $data = [
            'name' => $row['name'],
            'email' => $row['email'],
            'mobile' => $row['mobile'],
            'state' => $row['state'],
            'city' => $row['city'],
            'course' => $row['course'],
            'specialization' => $row['program'],
            'secret_key' => 'cab4bdbdfcf9c031ab5e899d5de01042',
            'source' => 'vidyavriddhi',
            'college_id' => '5645'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.in5.nopaperforms.com/dataporting/5645/vidyavriddhi");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (!curl_errno($ch)) {
            $responseDecoded = json_decode($response, true);

            if ($responseDecoded['status'] === 'Success') {
                $updateSql = "UPDATE enquiries SET submitted = 1 WHERE id = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("i", $row['id']);
                $updateStmt->execute();

                $successCount++;
            } else {
                $errors[] = "ID {$row['id']} - " . $responseDecoded['message'];
            }
        } else {
            $errors[] = "ID {$row['id']} - cURL Error: " . curl_error($ch);
        }

        curl_close($ch);
    }

    echo "$successCount records submitted successfully.";
    if (!empty($errors)) {
        echo "<br>Errors:<br>";
        echo implode("<br>", $errors);
    }
} else {
    echo "No records to submit.";
}
?>