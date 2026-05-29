<?php
$page = "manage";

require_once "settings.php";

$create_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

mysqli_query($conn, $create_users);

$check_admin = mysqli_query(
        $conn,
        "SELECT id FROM users WHERE username = 'admin'"
);

if ($check_admin && mysqli_num_rows($check_admin) == 0) {

    $admin_username = "admin";
    $admin_password = password_hash("admin", PASSWORD_DEFAULT);

    $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO users (username, password) VALUES (?, ?)"
    );

    mysqli_stmt_bind_param(
            $stmt,
            "ss",
            $admin_username,
            $admin_password
    );

    mysqli_stmt_execute($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Manager Login">
    <meta name="keywords" content="login, management">
    <meta name="author" content="Power Ed">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Login</title>

    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<?php
include 'header.inc';
include 'nav.inc';
?>

<main class="content">

    <h1>Management Login</h1>

    <p>
        Please log in to access the HR management system.
    </p>

    <form method="post" action="process.php" novalidate>

        <label for="username">Username:</label>
        <br>

        <input
                type="text"
                name="username"
                id="username"
        >

        <br><br>

        <label for="password">Password:</label>
        <br>

        <input
                type="password"
                name="password"
                id="password"
        >

        <br><br>

        <input
                type="submit"
                value="Login"
        >

    </form>

</main>

<?php include 'footer.inc'; ?>

</body>
</html>