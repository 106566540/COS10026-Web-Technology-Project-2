<?php
session_start();
#include 'header.inc';

    $page = "manage";
    include 'header.inc';
    include 'nav.inc';

if (isset($_SESSION['user'])) {
    echo "Welcome, to management page " . htmlspecialchars($_SESSION['user']) . "!";
} else {
    header('Location: login.html');
    exit();
}
#include 'footer.inc';
?>