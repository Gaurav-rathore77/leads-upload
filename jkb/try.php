<?php
include '../config.php'; // Ensure this file sets up $conn for database connection

$message = '';

// Process individual record submission if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['record_id'])) {
    $record_id = intval($_POST['record_id']);

    // Get the specific record from jkb table (only if not submitted yet)
    $stmt = $conn->prepare("SELECT * FROM jkb WHERE id = ? AND submitted_to_api = 0");
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Prepare the data for API submission
        $data = [
            'name' => $row['name'],
            'email' => $row['email'],
            'mobile' => $row['mobile'],
            'state' => $row['state'],
            'city' => $row['city'],
            'campus' => $row['program'],  // Assuming 'program' is the campus
            'course' => $row['course'],
            'secret_key' => 'db752e19721539fd65a92dfa0053498d',
            'source' => 'vidyavriddhi',
            'college_id' => '139'
        ];

        // Initialize and set up cURL to call the API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.nopaperforms.com/dataporting/139/vidyavriddhi");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        $responseDecoded = json_decode($response, true);

        // Check if the API call was successful
        if (!$curl_error && isset($responseDecoded['status']) && $responseDecoded['status'] === 'Success') {
            // Mark record as submitted
            $updateStmt = $conn->prepare("UPDATE jkb SET submitted_to_api = 1 WHERE id = ?");
            $updateStmt->bind_param("i", $record_id);
            $updateStmt->execute();
            $message = "Record ID {$record_id} submitted successfully.";
        } else {
            $errorMsg = $curl_error ? $curl_error : (isset($responseDecoded['message']) ? $responseDecoded['message'] : 'Unknown error');
            $message = "Error submitting record ID {$record_id}: {$errorMsg}";
        }
    } else {
        $message = "Record not found or already submitted.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Submit JKB Records</title>
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        form {
            display: inline;
        }
    </style>
</head>

<body>
    <h2>JKB Records</h2>
    <?php if (!empty($message)) {
        echo "<p><strong>$message</strong></p>";
    } ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch the first 20 records that haven't been submitted yet
            $sql = "SELECT id, name, email, mobile FROM jkb WHERE submitted_to_api = 0 LIMIT 20";
            $result = $conn->query($sql);
            if ($result) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
                        echo "<td>
                                <form method='post' onsubmit=\"return confirm('Submit this record?');\">
                                    <input type='hidden' name='record_id' value='" . $row['id'] . "'>
                                    <input type='submit' value='Submit'>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records available to submit.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Error: " . $conn->error . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>