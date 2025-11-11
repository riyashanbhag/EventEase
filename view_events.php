<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session safely
}

include 'db_connect.php'; // Database connection
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Events</title>

  <!-- Fonts + CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
<!-- ✅ Navbar -->
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
        <li class="nav-item"><a class="nav-link active" href="view_events.php">Events</a></li>

        <!-- Admin-only buttons -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
          <li class="nav-item">
            <a class="btn btn-success btn-sm ms-2" href="add_event.php">+ Add Event</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-warning btn-sm ms-2" href="view_registrations.php">View Registrations</a>
          </li>
        <?php endif; ?>

        <!-- Logged-in user -->
        <?php if (isset($_SESSION['email'])): ?>
          <li class="nav-item ms-3">
            <span class="nav-link">Hi, <?= htmlspecialchars($_SESSION['name']) ?></span>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-secondary btn-sm" href="logout.php">Logout</a>
          </li>
        <?php else: ?>
          <!-- Guest view -->
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

<!-- Page Heading -->
<h2 class="text-center mt-4 fw-semibold">Upcoming Events</h2>

<div class="container py-4">
  <div class="row g-4">

<?php
// Fetch events + registration status for logged-in user
if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];

    $sql = "SELECT e.*, (r.event_id IS NOT NULL) AS registered
            FROM events e
            LEFT JOIN registrations r 
            ON e.event_id = r.event_id AND r.user_email = ?
            ORDER BY e.date ASC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $user_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $result = mysqli_query($conn, "SELECT * FROM events ORDER BY date ASC");
}

// Show events
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $date = date("d M, Y", strtotime($row['date']));
        $registered = isset($row['registered']) && $row['registered'];

        echo "
        <div class='col-md-4'>
          <div class='card shadow-sm h-100 border-0'>
            <div class='card-body'>
              <h5 class='card-title fw-semibold'>" . htmlspecialchars($row['event_name']) . "</h5>
              <p class='card-text text-muted'>" . nl2br(htmlspecialchars($row['description'])) . "</p>
              <p class='meta small text-secondary'>
                <i class='fa fa-calendar'></i> $date 
                &nbsp; | &nbsp; 
                <i class='fa fa-map-marker-alt'></i> " . htmlspecialchars($row['venue']) . "
              </p>
            </div>
            <div class='card-footer bg-white border-0 d-flex justify-content-between align-items-center'>";
        
        // ✅ Role-based actions
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            echo "
              <div class='d-flex gap-2'>
                <span class='badge bg-secondary'>Admin View</span>
                <a href='delete_event.php?id={$row['event_id']}' 
                   class='btn btn-sm btn-outline-danger'
                   onclick='return confirm(\"Are you sure you want to delete this event?\")'>
                   <i class='fa fa-trash'></i> Delete
                </a>
              </div>";
        } elseif (isset($_SESSION['email'])) {
            if ($registered) {
                echo "<button class='btn btn-success btn-sm' disabled>Registered ✓</button>";
            } else {
                echo "<a href='register_event.php?id={$row['event_id']}' class='btn btn-sm btn-primary'>Register</a>";
            }
        } else {
            echo "<a href='login.php' class='btn btn-sm btn-outline-primary'>Login to Register</a>";
        }

        echo "<span class='badge bg-light text-dark'>ID: {$row['event_id']}</span>
            </div>
          </div>
        </div>";
    }
} else {
    echo "<div class='col-12'><div class='alert alert-info text-center'>No upcoming events.</div></div>";
}
?>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
