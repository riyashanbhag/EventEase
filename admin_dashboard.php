<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db_connect.php';

// Allow only admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
  header("Location: view_events.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - EventEase</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link rel="stylesheet" href="style.css">
  
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f9fafc;
    }
    .dashboard-card {
      max-width: 480px;
      margin: 80px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.06);
      padding: 35px;
      text-align: center;
    }
    .dashboard-card h2 {
      font-weight: 600;
      color: #007bff;
      margin-bottom: 8px;
    }
    .dashboard-card p {
      color: #666;
      margin-bottom: 25px;
    }
    .dashboard-buttons a {
      text-decoration: none;
      margin: 0 5px;
      padding: 8px 16px;
      border-radius: 6px;
      font-size: 14px;
      transition: all 0.2s ease-in-out;
    }
    .dashboard-buttons a.add {
      background-color: #198754;
      color: white;
    }
    .dashboard-buttons a.add:hover {
      background-color: #157347;
    }
    .dashboard-buttons a.view {
      background-color: #ffc107;
      color: #212529;
    }
    .dashboard-buttons a.view:hover {
      background-color: #e0a800;
    }
    .dashboard-buttons a.manage {
      background-color: #0d6efd;
      color: white;
    }
    .dashboard-buttons a.manage:hover {
      background-color: #0b5ed7;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light py-3 shadow-sm bg-white">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="index.php">
      <i class="fa-solid fa-calendar-check me-2"></i>EventEase
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="view_events.php">Events</a></li>

        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
          <li class="nav-item"><a class="btn btn-success btn-sm ms-2" href="add_event.php">+ Add Event</a></li>
          <li class="nav-item"><a class="btn btn-warning btn-sm ms-2" href="view_registrations.php">View Registrations</a></li>
        <?php endif; ?>

        <?php if(isset($_SESSION['email'])): ?>
          <li class="nav-item ms-3"><span class="nav-link">Hi, <?=htmlspecialchars($_SESSION['name'])?></span></li>
          <li class="nav-item"><a class="btn btn-outline-secondary btn-sm" href="logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="btn btn-primary btn-sm" href="login.php">Login</a></li>
          <li class="nav-item"><a class="btn btn-outline-primary btn-sm ms-2" href="register_user.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Dashboard -->
<div class="dashboard-card">
  <h2>Welcome, <?=htmlspecialchars($_SESSION['name'])?> </h2>
  <p>You are logged in as: <b><?=htmlspecialchars($_SESSION['role'])?></b></p>

  
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
