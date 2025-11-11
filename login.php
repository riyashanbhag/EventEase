<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session safely
}
include 'db_connect.php';


if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['email'] = $row['email'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['name'] = $row['name'];

    if ($row['role'] == 'admin') {
      header("Location: admin_dashboard.php");
    } else {
      header("Location: view_events.php");
    }
    exit();
  } else {
    echo "<script>alert('Invalid email or password');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - EventEase</title>

  <!-- Google Fonts + Bootstrap -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #6f42c1, #00a3ff);
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      padding: 40px 50px;
      width: 400px;
      text-align: center;
      animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-container h3 {
      color: #6f42c1;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .login-container p {
      color: #6c757d;
      margin-bottom: 25px;
    }

    .form-control {
      border-radius: 10px;
      padding: 10px;
      margin-bottom: 15px;
    }

    .btn-gradient {
      background: linear-gradient(90deg, #6f42c1, #00a3ff);
      border: none;
      color: white;
      font-weight: 600;
      border-radius: 10px;
      padding: 10px;
      width: 100%;
      transition: 0.3s;
    }

    .btn-gradient:hover {
      opacity: 0.9;
      transform: scale(1.02);
    }

    .link {
      color: #00a3ff;
      text-decoration: none;
      font-weight: 600;
    }

    .link:hover {
      text-decoration: underline;
    }

    .navbar {
      position: absolute;
      top: 0;
      width: 100%;
      background: rgba(255,255,255,0.9);
      backdrop-filter: blur(8px);
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<!-- Navbar -->
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

        <!-- ✅ Admin Only Link -->
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
          <li class="nav-item">
            <a class="btn btn-success btn-sm ms-2" href="add_event.php">
              + Add Event
            </a>
          </li>
           <li class="nav-item">
            <a class="btn btn-warning btn-sm ms-2" href="view_registrations.php">View Registrations</a>
          </li>
        <?php endif; ?>

        <!-- ✅ Logged In User Section -->
        <?php if(isset($_SESSION['email'])): ?>
          <li class="nav-item ms-3">
            <span class="nav-link">Hi, <?=htmlspecialchars($_SESSION['name'])?></span>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-secondary btn-sm" href="logout.php">Logout</a>
          </li>

        <!-- ✅ Guest Section -->
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

<!-- Centered Login Card -->
<div class="login-container">
  <h3>Welcome Back</h3>
  <p>Login to continue to <b>EventEase</b></p>

  <form method="POST">
    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
    <button type="submit" name="login" class="btn-gradient mt-2">Login</button>
  </form>

  <p class="mt-3">Don’t have an account? 
    <a href="register_user.php" class="link">Register here</a>
  </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
