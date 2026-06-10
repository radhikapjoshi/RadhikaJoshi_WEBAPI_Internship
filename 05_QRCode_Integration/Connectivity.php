<?php
$host = "localhost";
$user = "root";
$password = "";

// 1. Connect to MySQL without specifying a database yet
$conn = mysqli_connect($host, $user, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 2. Create the 'qrdemo' database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS qrdemo";
if (mysqli_query($conn, $sql)) {
    echo "Database 'qrdemo' verified/created successfully!<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

// 3. Now select the database to make sure it works
if (mysqli_select_db($conn, "qrdemo")) {
    echo "Successfully connected to 'qrdemo'!";
} else {
    echo "Could not select database.";
}
?>