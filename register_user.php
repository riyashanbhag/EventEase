<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session safely
}
include 'db_connect.php';


if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check if user already exists
  $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Email already registered! Please login.');</script>";
  } else {
    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'user')";
    if (mysqli_query($conn, $sql)) {
      echo "<script>alert('Registration successful! You can now log in.'); window.location='login.php';</script>";
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register - EventEase</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="col-md-6 mx-auto card p-4 shadow-lg">
      <h3 class="text-center mb-4 text-primary">Create an EventEase Account</h3>
      <form method="POST">
        <input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>
        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
      </form>
      <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
    </div>
  </div>
</body>
</html>
