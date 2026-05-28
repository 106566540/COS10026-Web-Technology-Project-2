<?php
session_start();

// Get form data safely
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$token = $_POST['token'] ?? ''; // from hidden field

// Simple login check
if ($username == 'admin' && $password == 'admin') {
    $_SESSION['user'] = $username;

    // Optional: store token in session (if needed for your assignment)
    $_SESSION['token'] = $token;

    header('Location: manage.php');
    exit();
} else {
    echo "Invalid login. <a href='login.php'>Try again</a>";
}
?>