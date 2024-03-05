<?php
session_start();
if (!isset($_SESSION['login_info'])) {
    header('Location: login.php');
    exit;
}
if (isset($_SESSION['login_info'])) {
    $json = $_SESSION['login_info'];
} else {
    echo "You are not logged in.";
}
