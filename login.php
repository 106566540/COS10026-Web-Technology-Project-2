<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
</head>
<body>
<?php include 'header.inc'; ?>
<h2>Login</h2>

<form method="post" action="process.php">
    
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br><br>

    <!-- Hidden token -->
    <input type="hidden" name="token" value="H106501172">

    <input type="submit" value="Login">

</form>
<?php include 'footer.inc'; ?>

</body>
</html>