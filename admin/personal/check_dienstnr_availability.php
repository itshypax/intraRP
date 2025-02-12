<?php
// Assuming you have a database connection established
include '../../assets/php/mysql-con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dienstnr = $_POST['dienstnr'];

    // Query the database to check if the dienstnr exists
    $query = "SELECT COUNT(*) as count FROM personal_profile WHERE dienstnr = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $dienstnr);

    if ($stmt->execute()) {
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            echo 'exists';
        } else {
            echo 'not_exists';
        }
    } else {
        // Handle database query error
        echo 'error';
    }
}
