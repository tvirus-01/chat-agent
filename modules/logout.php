<?php
$path = '../';

// if (!isset($_POST['logout'])) {
// 	header('Location: '.$path.'index.php');
// }

if (isset($_COOKIE['client']) && isset($_COOKIE['client_type'])) {
    unset($_COOKIE['client']);
    unset($_COOKIE['client_type']);
    setcookie('client', '', time() - 93600, '/');
    setcookie('client_type', '', time() - 93600, '/');
    header('Location: '.$path.'index.php');
}