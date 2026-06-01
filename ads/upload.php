<?php
include('db.php'); // DB connection file

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];
    $handle = fopen($file, "r");

    if ($handle !== FALSE) {
        fgetcsv($handle); // skip header row

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $keyword = $data[0];
            $avg_monthly_searches = (int)str_replace(',', '', $data[1]);
            $three_month_change = $data[2];
            $yoy_change = $data[3];
            $competition = $data[4];
            $competition_indexed_value = (float)$data[5];
            $top_bid_low = (float)$data[6];
            $top_bid_high = (float)$data[7];

            $stmt = $pdo->prepare("INSERT INTO keyword_data (keyword, avg_monthly_searches, three_month_change, yoy_change, competition, competition_indexed_value, top_bid_low, top_bid_high) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$keyword, $avg_monthly_searches, $three_month_change, $yoy_change, $competition, $competition_indexed_value, $top_bid_low, $top_bid_high]);
        }

        fclose($handle);
        echo "✅ Upload complete!";
    } else {
        echo "❌ Failed to open file.";
    }
}
?>
