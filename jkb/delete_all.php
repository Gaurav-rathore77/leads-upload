<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "DELETE FROM jkb"; // Query to delete all records

    if ($conn->query($query) === TRUE) {
        echo "<script>
            alert('All records deleted successfully!');
            window.location.href = 'index.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Failed to delete records: " . addslashes($conn->error) . "');
            window.location.href = 'index.php';
        </script>";
        exit;
    }
} else {
    echo "<script>
        alert('Invalid request!');
        window.location.href = 'index.php';
    </script>";
    exit;
}
?>