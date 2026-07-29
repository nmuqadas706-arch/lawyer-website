<?php
include_once 'includes/connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Check current status
    $check_query = "SELECT status FROM lawyers WHERE lawyer_id='$id'";
    $check_result = mysqli_query($conn, $check_query);
    $row = mysqli_fetch_assoc($check_result);
    
    if($row && $row['status'] === 'Approved') {
        echo "<script>alert('Lawyer is already Approved!'); window.location.href='admin.php';</script>";
    } else {
        $query = "UPDATE lawyers SET status='Approved' WHERE lawyer_id='$id'";
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Lawyer Approved Successfully!'); window.location.href='admin.php';</script>";
        } else {
            echo "<script>alert('Failed to Approve Lawyer. Please try again.'); window.location.href='admin.php';</script>";
        }
    }
} else {
    header("Location: admin.php");
}
?>
