<?php
session_start();
if(session_destroy()) {
    if (isset($_COOKIE['user'])) {
        setcookie("user", "",time() + (7 * 24 * 60 * 60), "/"); // Clear the cookie
    }
    header("Location: login.php");
}
?>
