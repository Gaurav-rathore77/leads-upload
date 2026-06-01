<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (!empty($start_date) && !empty($end_date)) {
        $sql = "DELETE FROM enquiries WHERE DATE(created_at) BETWEEN '$start_date' AND '$end_date'";
        if ($conn->query($sql)) {
            $message = "Records between $start_date and $end_date have been deleted successfully.";
        } else {
            $message = "Error deleting records: " . $conn->error;
        }
    } else {
        $message = "Please select both start and end dates.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Enquiries</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h2>Delete Enquiries by Date Range</h2>

    <!-- Display message if any -->
    <?php if (!empty($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Date Range Form -->
    <form action="delete_enquiries.php" method="POST">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>

        <button type="submit">Delete Records</button>
    </form>

    <!-- Back to Dashboard -->
    <br>
    <a href="index.php">Back to Dashboard</a>
</body>

</html>