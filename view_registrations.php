<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session safely
}
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}
include 'db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>View Registrations</title>
  <link rel="stylesheet" href="style.css">
  <!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Your custom CSS -->
<link rel="stylesheet" href="style.css">

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

  <h2>All Event Registrations</h2>
  <table border="1" align="center" cellpadding="10">
    <tr>
      <th>Participant Name</th>
      <th>Email</th>
      <th>Event ID</th>
      <th>Registered On</th>
    </tr>
    <?php
    $res = mysqli_query($conn, "SELECT * FROM registrations ORDER BY reg_date DESC");
    while ($row = mysqli_fetch_assoc($res)) {
      echo "<tr>
              <td>{$row['user_name']}</td>
              <td>{$row['user_email']}</td>
              <td>{$row['event_id']}</td>
              <td>{$row['reg_date']}</td>
            </tr>";
    }
    ?>
  </table>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
