<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    // File details
    $fileTmpPath = $_FILES['csv_file']['tmp_name'];

    // Desired headers
    $desiredHeaders = [
        "full_name",
        "email",
        "phone_number",
        "state",
        "city",
        "Program",
        "course"
    ];
    $correctedData = []; // To store the corrected data

    // Open the uploaded file
    if (($handle = fopen($fileTmpPath, "r")) !== false) {
        $rowIndex = 0;
        while (($row = fgetcsv($handle, 1000, ",")) !== false) {
            if ($rowIndex === 0) {
                // Validate header count
                if (count($row) !== count($desiredHeaders)) {
                    echo "Error: CSV headers do not match the expected format.";
                    exit;
                }
                $correctedData[] = $desiredHeaders; // Use desired headers
            } else {
                // Map data directly (ignoring unnecessary columns like 'Country code')
                $filteredRow = array_slice($row, 0, count($desiredHeaders));
                $correctedData[] = $filteredRow;
            }
            $rowIndex++;
        }
        fclose($handle);

        // Save the corrected CSV
        $correctedFilePath = 'corrected_file.csv';
        $fp = fopen($correctedFilePath, 'w');
        foreach ($correctedData as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);

        echo "CSV file successfully corrected! Download it <a href='$correctedFilePath'>here</a>.";
    } else {
        echo "Failed to open the uploaded file.";
    }
} else {
    ?>
    <form method="POST" enctype="multipart/form-data">
        <label for="csv_file">Upload CSV File:</label>
        <input type="file" name="csv_file" id="csv_file" required>
        <button type="submit">Upload and Correct</button>
    </form>
    <?php
}
?>