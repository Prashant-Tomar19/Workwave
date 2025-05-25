<?php
$servername = "localhost";
$username = "root";
$password = ""; // your DB password
$dbname = "user_auth";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = trim($_POST['username']);
$entered_password = $_POST['password'];

$sql = "SELECT password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  $stmt->bind_result($hashed_password);
  $stmt->fetch();

  if (password_verify($entered_password, $hashed_password)) {
    echo "Login successful!";
  } else {
    echo "Invalid email or password.";
  }
} else {
  echo "No account found with this email.";
}

$stmt->close();
$conn->close();
?>
