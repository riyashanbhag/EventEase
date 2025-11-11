<?php
$conn = mysqli_connect("localhost", "root", "", "event_system");

if (!$conn) {
  die("❌ Database connection failed: " . mysqli_connect_error());
}   
?>
