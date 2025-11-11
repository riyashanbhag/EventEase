<?php
$conn = mysqli_connect("localhost", "root", "", "acmw_events");
if ($conn) {
  echo "✅ Connected Successfully!";
} else {
  echo "❌ Connection Failed: " . mysqli_connect_error();
}
?>
