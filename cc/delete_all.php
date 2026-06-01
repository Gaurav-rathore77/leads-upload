<?php
include '../config.php';

// Check if the delete all request is triggered
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "DELETE FROM enquiries"; // Query to delete all records

    if ($conn->query($query) === TRUE) {
        // Redirect back to index.php with a JavaScript alert for success
        echo "<script>
            alert('All records deleted successfully!');
            window.location.href = 'index.php';
        </script>";
        exit;
    } else {
        // Redirect back to index.php with a JavaScript alert for error
        echo "<script>
            alert('Failed to delete records: " . addslashes($conn->error) . "');
            window.location.href = 'index.php';
        </script>";
        exit;
    }
} else {
    // Redirect back to index.php if the request method is invalid
    echo "<script>
        alert('Invalid request!');
        window.location.href = 'index.php';
    </script>";
    exit;
}
?>