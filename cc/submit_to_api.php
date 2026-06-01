<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Get the ID from the POST request
    $id = (int) $_POST['id']; // Ensure the ID is an integer to prevent SQL injection

    // Prepare SQL query to fetch record by ID
    $sql = "SELECT * FROM enquiries WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('SQL Error (Select): ' . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the record data
        $row = $result->fetch_assoc();

        // Prepare the data for the API request
        $data = [
            'name' => $row['name'], // Matches 'full_name' in CSV
            'email' => $row['email'],
            'mobile' => $row['mobile'], // Matches 'phone_number' in CSV
            'state' => $row['state'],
            'city' => $row['city'],
            'course' => $row['course'],
            'specialization' => $row['program'], // Matches 'Program' in CSV
            'secret_key' => 'cab4bdbdfcf9c031ab5e899d5de01042',
            'source' => 'vidyavriddhi',
            'college_id' => '5645'
        ];

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.in5.nopaperforms.com/dataporting/5645/vidyavriddhi");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        if (!curl_errno($ch)) {
            $responseDecoded = json_decode($response, true);

            if ($responseDecoded['status'] === 'Success') {
                // Update 'submitted_to_api' status
                $updateSql = "UPDATE enquiries SET submitted = 1 WHERE id = ?";
                $updateStmt = $conn->prepare($updateSql);

                if ($updateStmt === false) {
                    die('SQL Error (Update): ' . $conn->error);
                }

                $updateStmt->bind_param("i", $id);
                $updateStmt->execute();

                // Insert record into 'submitted_enquiries'
                $insertSql = "INSERT INTO submitted_enquiries (name, email, mobile, state, city, course, specialization, submitted) 
                              SELECT name, email, mobile, state, city, course, program, submitted 
                              FROM enquiries WHERE id = ?";
                $insertStmt = $conn->prepare($insertSql);

                if ($insertStmt === false) {
                    die('SQL Error (Insert): ' . $conn->error);
                }

                $insertStmt->bind_param("i", $id);
                $insertStmt->execute();

                echo "Submitted successfully!";
            } else {
                echo "API Error: " . $responseDecoded['message'];
            }
        } else {
            echo "cURL Error: " . curl_error($ch);
        }

        curl_close($ch);
    } else {
        echo "Record not found.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>