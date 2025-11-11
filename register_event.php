<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';

if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please log in to register for events.'); window.location='login.php';</script>";
    exit;
}

$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$name = $_SESSION['name'];
$email = $_SESSION['email'];

// Check if already registered
$check = mysqli_query($conn, "SELECT * FROM registrations WHERE user_email='$email' AND event_id='$event_id'");
if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('You are already registered for this event!'); window.location='view_events.php';</script>";
    exit;
}

// Register new entry
$query = "INSERT INTO registrations (user_name, user_email, event_id) VALUES ('$name', '$email', '$event_id')";
if (mysqli_query($conn, $query)) {
    echo "<script>alert('Registration successful!'); window.location='view_events.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
