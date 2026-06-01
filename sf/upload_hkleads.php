<?php
include '../config.php'; // $conn must be set

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['csv_file']['tmp_name'];
        $fileName = $_FILES['csv_file']['name'];

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($fileExtension !== 'csv') {
            die('Error: Please upload a valid CSV file.');
        }

        $file = fopen($fileTmpPath, 'r');
        $header = fgetcsv($file);

        // Remove BOM
        if (ord($header[0][0]) === 239 && ord($header[0][1]) === 187 && ord($header[0][2]) === 191) {
            $header[0] = substr($header[0], 3);
        }

        $header = array_map('trim', $header);

        // Expected headers based on your CSV
        $expected_header = ['program', 'full_name', 'email', 'phone_number', 'city'];

        if ($header !== $expected_header) {
            die('Error: CSV headers do not match expected format.<br>Expected: ' . implode(', ', $expected_header) . '<br>Found: ' . implode(', ', $header));
        }

        // Insert rows
        while (($row = fgetcsv($file)) !== false) {
            $data = [
                'program' => $row[0],
                'full_name' => $row[1],
                'email' => $row[2],
                'phone_number' => $row[3],
                'city' => $row[4],
                'submitted_to_api' => 0
            ];

            $stmt = $conn->prepare("INSERT INTO hkleads (program, full_name, email, phone_number, city, submitted_to_api) VALUES (?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                die('SQL prepare error: ' . $conn->error);
            }

            $stmt->bind_param('sssssi', $data['program'], $data['full_name'], $data['email'], $data['phone_number'], $data['city'], $data['submitted_to_api']);

            if (!$stmt->execute()) {
                echo "Insert Error: " . $stmt->error . "<br>";
            }

            $stmt->close();
        }

        fclose($file);
        echo "✅ CSV uploaded successfully!";
    } else {
        echo "❌ File upload error.";
    }
}
?>