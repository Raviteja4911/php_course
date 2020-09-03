<?php
session_start();
unset($_SESSION['name']);
unset($_SESSION['user_id']);
$_SESSION['logged_in']=false;
header('Location: index.php');
