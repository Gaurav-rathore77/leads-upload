<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Get the ID from the POST request
    $id = (int) $_POST['id']; // Ensure the ID is an integer to prevent SQL injection

    // Prepare SQL query to fetch record by ID
    $sql = "SELECT * FROM ies WHERE id = ?";
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

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.in5.nopaperforms.com/dataporting/5075/vidyavriddhi");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check if the cURL request was successful
        if ($response === false) {
            echo "cURL Error: " . curl_error($ch);
        } else {
            // Decode the response (assuming it's in JSON format)
            $decodedResponse = json_decode($response, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                // Display the decoded response
                echo "API Response: <br>";
                echo "<pre>" . print_r($decodedResponse, true) . "</pre>";
            } else {
                // If response is not JSON, display raw response
                echo "Raw API Response: " . htmlspecialchars($response);
            }
        }

        // Close cURL session
        curl_close($ch);
    } else {
        echo "Record not found.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>