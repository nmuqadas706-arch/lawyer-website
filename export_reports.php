<?php
/*
 * Database Connection & Authorization
 * This block connects to the DB and checks if the admin is logged in.
 */
include 'includes/connection.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    die('Unauthorized access');
}

/*
 * Handle CSV Export
 * Selects all appointment logs from the database and outputs them as a downloadable CSV.
 */
if (isset($_GET['type']) && $_GET['type'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="appointments_report.csv"');
    
    $output = fopen('php://output', 'w');
    // Write headers
    fputcsv($output, ['Appointment ID', 'Customer Name', 'Lawyer Name', 'Service Name', 'Date', 'Time', 'Status']);

    $query = "
        SELECT a.appointment_id, c.full_name as customer, l.full_name as lawyer, s.service_name, a.appointment_date, a.appointment_time, a.status 
        FROM appointments a
        JOIN customers c ON a.customer_id = c.customer_id
        JOIN lawyers l ON a.lawyer_id = l.lawyer_id
        JOIN services s ON a.service_id = s.service_id
        ORDER BY a.appointment_id DESC
    ";
    
    $result = mysqli_query($conn, $query);

    // Write data rows
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    
    fclose($output);
    exit();
}
?>
