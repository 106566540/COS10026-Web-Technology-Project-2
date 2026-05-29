<?php
$host = "localhost";
$user = "root";
$pwd = "";
$sql_db = "power_ed";

$conn = mysqli_connect($host, $user, $pwd);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $sql_db");
mysqli_select_db($conn, $sql_db);

function create_tables($conn) {
    $eoi_sql = "CREATE TABLE IF NOT EXISTS eoi (
        EOInumber INT AUTO_INCREMENT PRIMARY KEY,
        job_reference VARCHAR(5) NOT NULL,
        first_name VARCHAR(20) NOT NULL,
        last_name VARCHAR(20) NOT NULL,
        dob VARCHAR(10) NOT NULL,
        gender VARCHAR(20) NOT NULL,
        street_address VARCHAR(40) NOT NULL,
        suburb VARCHAR(40) NOT NULL,
        state VARCHAR(3) NOT NULL,
        postcode VARCHAR(4) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(12) NOT NULL,
        skills TEXT,
        other_skills TEXT,
        status ENUM('New', 'Current', 'Final') DEFAULT 'New'
    )";

    $users_sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )";

    mysqli_query($conn, $eoi_sql);
    mysqli_query($conn, $users_sql);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='admin'");
    if (mysqli_num_rows($check) == 0) {
        $hash = password_hash("admin", PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES ('admin', ?)");
        mysqli_stmt_bind_param($stmt, "s", $hash);
        mysqli_stmt_execute($stmt);
    }
}

create_tables($conn);
?>