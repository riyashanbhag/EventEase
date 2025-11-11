<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EventEase - Home</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(180deg, #f6f9ff 0%, #e9f1ff 100%);
      margin: 0;
      padding: 0;
    }

    /* Navbar styling */
    .navbar {
      background: #fff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    /* Hero section */
    .hero {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      height: 80vh;
      padding: 20px;
      color: #222;
    }

    .hero h1 {
      font-size: 2.8rem;
      font-weight: 700;
      background: linear-gradient(90deg, #6f42c1, #00a3ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero p {
      color: #555;
      max-width: 600px;
      margin-top: 15px;
      font-size: 1.1rem;
    }

    .btn-gradient {
      background: linear-gradient(90deg, #6f42c1, #00a3ff);
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 10px;
      margin: 10px;
      font-weight: 600;
      transition: 0.3s ease;
    }

    .btn-gradient:hover {
      opacity: 0.9;
      transform: scale(1.03);
    }

    .hero img {
      max-width: 450px;
      width: 100%;
      margin-top: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    footer {
      background: #fff;
      color: #555;
      text-align: center;
      padding: 15px;
      margin-top: 40px;
      font-size: 14px;
      box-shadow: 0 -3px 10px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light py-3 shadow-sm">
  <div class="container">
    <!-- Brand -->
    <a class="navbar-brand fw-bold text-primary" href="index.php">
      <i class="fa-solid fa-calendar-check me-2"></i>EventEase
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Links -->
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto align-items-lg-center">

        <!-- General Links -->
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="view_events.php">Events</a></li>

        <!-- Admin Only Links -->
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
          <li class="nav-item">
            <a class="btn btn-success btn-sm ms-2" href="add_event.php">+ Add Event</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-warning btn-sm ms-2" href="view_registrations.php">View Registrations</a>
          </li>
        <?php endif; ?>

        <!-- Logged In User Section -->
        <?php if(isset($_SESSION['email'])): ?>
          <li class="nav-item ms-3">
            <span class="nav-link">Hi, <?=htmlspecialchars($_SESSION['name'])?></span>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-secondary btn-sm" href="logout.php">Logout</a>
          </li>

        <!-- Guest Section -->
        <?php else: ?>
          <li class="nav-item">
            <a class="btn btn-primary btn-sm" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-primary btn-sm ms-2" href="register_user.php">Register</a>
          </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <h1>Welcome to EventEase </h1>
  <p>
    EventEase is your all-in-one platform to create, manage, and register for events effortlessly.
    Whether it’s a college workshop, tech talk, or cultural event — we make organizing fun and easy!
  </p>

  <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
    <div>
      <a href="add_event.php" class="btn-gradient">Create New Event</a>
      <a href="view_registrations.php" class="btn btn-outline-dark btn-lg">View Registrations</a>
    </div>
  <?php else: ?>
    <div>
      <a href="view_events.php" class="btn-gradient">View Events</a>
      <a href="register_user.php" class="btn btn-outline-dark btn-lg">Join Now</a>
    </div>
  <?php endif; ?>

  <img src="https://img.freepik.com/premium-vector/event-management-wedding-planner-manager-planning-event-conference-party_501813-2157.jpg?semt=ais_hybrid&w=740&q=80">

</section>

<footer>
  © 2025 EventEase 
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
