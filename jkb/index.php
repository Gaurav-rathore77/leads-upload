<?php
include '../config.php';

$result = $conn->query("SELECT * FROM jkb");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <h2>Enquiry Data</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="csv_file" required>
        <button type="submit">Upload CSV</button>
    </form>

    <!-- Button to submit all entries to the API -->
    <form action="submit_all_to_api.php" method="POST" style="margin-top: 20px;">
        <button type="submit" style="background-color: green; color: white; padding: 10px;">Submit All to API</button>
    </form>
    <form action="submit-to-bss.php" method="POST" style="margin-top: 20px;">
        <button type="submit" style="background-color: yellow; color: #222; padding: 10px;">Submit to BSS</button>
    </form>

    <!-- Button to delete all entries -->
    <form action="delete_all.php" method="POST" style="margin-top: 20px;">
        <button type="submit" style="background-color: red; color: white; padding: 10px;">Delete All</button>
    </form>

    <table id="enquiryTable" class="display">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>State</th>
                <th>City</th>
                <th>Course</th>
                <th>Program</th>
                <th>Submitted to API</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo $row['state']; ?></td>
                    <td><?php echo $row['city']; ?></td>
                    <td><?php echo $row['program']; ?></td>
                    <td><?php echo $row['course']; ?></td>
                    <td><?php echo $row['submitted_to_api'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <form action="submit_to_api.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Submit</button>
                        </form>
                        <form action="delete.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $('#enquiryTable').DataTable();
        });
    </script>
</body>

</html>