<?php
session_start();
session_destroy(); // ❌ delete all session data
header("Location: login.php");
exit();
?>
