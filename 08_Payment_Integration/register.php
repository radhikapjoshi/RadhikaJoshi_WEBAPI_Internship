<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {

    $fullname = trim($data['fullname'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = trim($data['password'] ?? '');

} else {

    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

}

if (empty($fullname)) {
    echo json_encode([
        "status" => false,
        "message" => "Full Name is required"
    ]);
    exit;
}

if (empty($email)) {
    echo json_encode([
        "status" => false,
        "message" => "Email is required"
    ]);
    exit;
}

if (empty($password)) {
    echo json_encode([
        "status" => false,
        "message" => "Password is required"
    ]);
    exit;
}


$check = mysqli_query($conn,"SELECT id FROM users WHERE email='$email'");

if (mysqli_num_rows($check) > 0) {

    echo json_encode([
        "status" => false,
        "message" => "Email already registered"
    ]);
    exit;

}

$hash_password = password_hash($password,PASSWORD_DEFAULT);

$sql = "INSERT INTO users (fullname, email, password)
        VALUES ( '$fullname', '$email', '$hash_password' )";

$result = mysqli_query($conn, $sql);

if ($result) {

    echo json_encode([
        "status" => true,
        "message" => "Registration Successful"
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Registration Failed",
        "error" => mysqli_error($conn)
    ]);

}

?>