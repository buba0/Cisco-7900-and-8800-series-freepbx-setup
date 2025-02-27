<?php
// add_contact.php

// Database connection settings
require_once "config.php";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $name  = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    
    $sql = "INSERT INTO employees (name, phone) VALUES ('$name', '$phone')";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to contacts list
        header("Location: contacts.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
