<?php
include('db.php');
$stmt = $pdo->query("SELECT * FROM keyword_data ORDER BY avg_monthly_searches DESC");
$keywords = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Keyword Table</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <h2>Keyword Research Data</h2>
    <table id="keywordTable" class="display">
        <thead>
            <tr>
                <th>Keyword</th>
                <th>Avg. Monthly Searches</th>
                <th>3M Change</th>
                <th>YoY Change</th>
                <th>Competition</th>
                <th>Competition Index</th>
                <th>Top Bid (Low)</th>
                <th>Top Bid (High)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($keywords as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['keyword']) ?></td>
                    <td><?= $row['avg_monthly_searches'] ?></td>
                    <td><?= $row['three_month_change'] ?></td>
                    <td><?= $row['yoy_change'] ?></td>
                    <td><?= $row['competition'] ?></td>
                    <td><?= $row['competition_indexed_value'] ?></td>
                    <td><?= $row['top_bid_low'] ?></td>
                    <td><?= $row['top_bid_high'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $('#keywordTable').DataTable({
                pageLength: 25
            });
        });
    </script>
</body>
</html>
