<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_all'])) {
        $sql = "DELETE FROM hkleads";
        if ($conn->query($sql)) {
            echo "<p style='color:green;'>✅ All records deleted successfully.</p>";
        } else {
            echo "<p style='color:red;'>❌ Error: " . $conn->error . "</p>";
        }
    } elseif (isset($_POST['delete_unsubmitted'])) {
        $sql = "DELETE FROM hkleads WHERE submitted_to_api = 0";
        if ($conn->query($sql)) {
            echo "<p style='color:green;'>✅ Unsubmitted records deleted successfully.</p>";
        } else {
            echo "<p style='color:red;'>❌ Error: " . $conn->error . "</p>";
        }
    }
}
?>

<h3>🧹 Delete Records from `hkleads` Table</h3>

<form method="post" onsubmit="return confirm('Are you sure you want to proceed?');">
    <button type="submit" name="delete_all" style="background:red; color:white; padding:10px 20px; border:none;">🗑
        Delete All Records</button>
    <br><br>
    <button type="submit" name="delete_unsubmitted"
        style="background:orange; color:white; padding:10px 20px; border:none;">🗂 Delete Only Unsubmitted
        Records</button>
</form>