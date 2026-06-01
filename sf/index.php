<?php
include '../config.php';
$result = $conn->query("SELECT * FROM hkleads");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>HK Leads Dashboard</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
        form {
            display: inline-block;
            margin: 10px 10px 20px 0;
        }

        button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .upload-btn {
            background-color: #3498db;
            color: white;
        }

        .submit-btn {
            background-color: #27ae60;
            color: white;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>

<body>

    <h2>HK Leads Data</h2>

    <!-- Upload CSV -->
    <form action="upload_hkleads.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="csv_file" required>
        <button class="upload-btn" type="submit">📤 Upload CSV</button>
    </form>

    <!-- Submit All to API -->
    <form action="submit_all_to_api_hkleads.php" method="POST">
        <button class="submit-btn" type="submit">🚀 Submit All to API</button>
    </form>

    <!-- Delete All -->
    <form action="delete_all_hkleads.php" method="POST"
        onsubmit="return confirm('Are you sure you want to delete all records?');">
        <button class="delete-btn" type="submit">🗑️ Delete All</button>
    </form>

    <table id="leadsTable" class="display">
        <thead>
            <tr>
                <th>Program</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>City</th>
                <th>Submitted</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['program']) ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone_number']) ?></td>
                    <td><?= htmlspecialchars($row['city']) ?></td>
                    <td><?= $row['submitted_to_api'] ? '✅' : '❌' ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $('#leadsTable').DataTable();
        });
    </script>

</body>

</html>