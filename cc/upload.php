<?php
include '../config.php'; // Ensure $conn is properly set in this file.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['csv_file']['tmp_name'];
        $fileName = $_FILES['csv_file']['name'];

        // Check file extension (ensure it's a CSV file)
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($fileExtension !== 'csv') {
            die('Error: Please upload a valid CSV file.');
        }

        // Open the CSV file
        $file = fopen($fileTmpPath, 'r');
        $header = fgetcsv($file);  // Read the first line (headers)

        // Remove BOM if it exists by checking for BOM and removing it
        if (ord($header[0][0]) === 239 && ord($header[0][1]) === 187 && ord($header[0][2]) === 191) {
            // Remove BOM from header
            $header[0] = substr($header[0], 3);
        }

        // Trim any extra spaces (including potential BOM and whitespaces)
        $header = array_map('trim', $header);

        // Debug: Print the headers to see what's being read
        echo "<pre>";
        print_r($header);
        echo "</pre>";

        // Define the expected header
        $expected_header = ['full_name', 'email', 'phone_number', 'state', 'city', 'Program', 'course'];

        // Check if the headers match the expected format
        if ($header !== $expected_header) {
            die('Error: CSV headers do not match the expected format. Here is the actual header: ' . implode(", ", $header));
        }

        // Prepare and insert each row
        while (($row = fgetcsv($file)) !== false) {
            // Prepare the data for insertion
            $data = [
                'name' => $row[0],      // full_name
                'email' => $row[1],
                'mobile' => $row[2],
                'state' => $row[3],
                'city' => $row[4],
                'program' => $row[5],
                'course' => $row[6],
                'submitted' => 0       // Ensure default is 0 (not submitted)
            ];

            // Prepare the SQL statement
            $stmt = $conn->prepare("INSERT INTO enquiries (name, email, mobile, state, city, program, course, submitted) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            // Debug: Check if the statement was prepared successfully
            if ($stmt === false) {
                die('Error: Failed to prepare SQL statement. MySQL Error: ' . $conn->error);
            }

            // Bind parameters to the prepared statement
            $stmt->bind_param('ssssssss', $data['name'], $data['email'], $data['mobile'], $data['state'], $data['city'], $data['program'], $data['course'], $data['submitted']);

            // Execute the prepared statement
            if (!$stmt->execute()) {
                echo "Error inserting row: " . $stmt->error . "<br>";
            }

            // Free result and close the statement
            $stmt->free_result();
        }

        // Close the CSV file
        fclose($file);

        echo "CSV data successfully uploaded.";
    } else {
        echo "Error uploading file.";
    }
}
?>