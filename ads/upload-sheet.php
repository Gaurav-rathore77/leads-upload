<!DOCTYPE html>
<html>
<head>
    <title>Upload Keyword CSV</title>
</head>
<body>
    <h2>Upload Keyword CSV</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="csv_file" accept=".csv" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
