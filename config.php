<?php
$conn = new mysqli("localhost", "root", "", "vvupload");
// $conn = new mysqli("localhost", "u703597236_vv", "@Shubham#01", "u703597236_vv");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>