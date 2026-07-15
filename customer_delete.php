<?php
include_once 'includes/connection.php';
session_start();

// Security Check
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete customer
    $query = "DELETE FROM customers WHERE customer_id='$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Client deleted successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href='admin.php';</script>";
    }
} else {
    echo "<script>alert('Invalid ID!'); window.location.href='admin.php';</script>";
}
?>
