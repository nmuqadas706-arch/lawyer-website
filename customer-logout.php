<?php
include_once 'includes/connection.php';
session_start();
session_destroy();
header("Location: customer-login.php");
exit();
?>