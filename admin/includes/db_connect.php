<?php
$conn = null;
try {
    $conn = new mysqli('localhost', 'root', '', 'fos_db');
    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>