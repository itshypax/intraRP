<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../../assets/php/permissions.php';
// Set the upload directory path
$upload_dir = '../../assets/upload/';
// Get the file details
$file_name = $_FILES['file']['name'];
$file_type = $_FILES['file']['type'];
$file_size = $_FILES['file']['size'];
$file_tmp_name = $_FILES['file']['tmp_name'];
$user_name = $_SESSION['cirs_user'];
$upload_time = date('Y-m-d H:i:s');
// Validate file type
if (!in_array($file_type, array('image/png', 'image/jpeg', 'image/gif', 'application/pdf'))) {
    echo 'Ungültiger Datei-Typ! Es können nur png, jpg, gif und pdf Dateien hochgeladen werden.' . $_FILES['file']['type'];
    exit;
}
// Move the uploaded file to the upload directory
if (move_uploaded_file($file_tmp_name, $upload_dir . $file_name)) {
    // Store the file details in the database
    include '../../assets/php/mysql-con.php';
    $sql = "INSERT INTO cirs_uploads (file_name, file_type, file_size, user_name, upload_time) 
            VALUES ('$file_name', '$file_type', '$file_size', '$user_name', '$upload_time')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // Display a success message
        echo $upload_dir . $file_name;
    } else {
        echo 'Fehler beim Speichern der Datei in der Datenbank.';
    }
} else {
    echo 'Fehler beim Speichern der Datei.';
}
