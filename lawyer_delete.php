<?php
include_once 'includes/connection.php';
session_start();

// Security Check: Only Admin can delete
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Check if ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Optional: Get image name before deleting so you can remove the actual file from server
    $img_query = mysqli_query($conn, "SELECT profile_image FROM lawyers WHERE lawyer_id='$id'");
    if($img_query && mysqli_num_rows($img_query) > 0) {
        $img_row = mysqli_fetch_assoc($img_query);
        $image_path = "uploads/" . $img_row['profile_image'];
        
        // If file exists and is not empty string, delete it from folder
        if(!empty($img_row['profile_image']) && file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // Delete query
    $delete_query = "DELETE FROM lawyers WHERE lawyer_id='$id'";
    
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>
            alert('Lawyer profile has been deleted successfully!');
            window.location.href = 'admin.php';
        </script>";
    } else {
        echo "<script>
            alert('Error deleting lawyer: " . mysqli_error($conn) . "');
            window.location.href = 'admin.php';
        </script>";
    }

} else {
    echo "<script>
        alert('Invalid Request! Lawyer ID not found.');
        window.location.href = 'admin.php';
    </script>";
}
?>
