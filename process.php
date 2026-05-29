<?php
session_start();
require_once "settings.php";

$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";

$stmt = mysqli_prepare($conn, "SELECT password FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $row["password"])) {
        $_SESSION["user"] = $username;
        header("Location: manage.php");
        exit();
    }
}

echo "Invalid login. <a href='login.php'>Try again</a>";
?>