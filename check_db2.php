<?php include_once 'includes/connection.php'; $r = mysqli_query($conn, 'SHOW COLUMNS FROM lawyers'); while($row = mysqli_fetch_assoc($r)) { echo $row['Field'] . ' '; } ?>
