<?php
session_start();
include 'db_connect.php';

// Only admin can delete
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: view_events.php");
    exit();
}

if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']);
    
    $query = "DELETE FROM events WHERE event_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $event_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Event deleted successfully!'); window.location='view_events.php';</script>";
    } else {
        echo "<script>alert('Error deleting event.'); window.location='view_events.php';</script>";
    }
}
?>
