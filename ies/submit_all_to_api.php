<?php
include '../config.php';
$sql = "SELECT * FROM ies WHERE submitted_to_api = 0";
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
            'name' => $row['name'],
            'email' => $row['email'],
            'mobile' => $row['mobile'],
            'state' => $row['state'],
            'city' => $row['city'],
            'campus' => $row['program'],
            'course' => $row['course'],
            'secret_key' => '0141d388df8ef2da0ff97c81d6261c83',
            'source' => 'vidyavriddhi',
            'college_id' => '5075'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.in5.nopaperforms.com/dataporting/5075/vidyavriddhi");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (!curl_errno($ch)) {
            $responseDecoded = json_decode($response, true);

            if ($responseDecoded['status'] === 'Success') {
                $updateSql = "UPDATE enquiries SET submitted_to_api = 1 WHERE id = ?";
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

    echo "$successCount records submitted to api successfully.";
    if (!empty($errors)) {
        echo "<br>Errors:<br>";
        echo implode("<br>", $errors);
    }
} else {
    echo "No records to submit.";
}
?>