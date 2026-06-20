<?php

include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
} else {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
}

if (empty($email) || empty($password)) {
    echo json_encode([
        "status" => false,
        "message" => "Email and Password Required"
    ]);
    exit;
}

$q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'
     AND status='active'" );

if(mysqli_num_rows($q)>0){

    $row=mysqli_fetch_assoc($q);

    if(password_verify($password,$row['password'])){

        $token = bin2hex(random_bytes(32));

        mysqli_query($conn, "UPDATE users SET api_token='$token' WHERE id=".$row['id']);

        echo json_encode([
            "status"=>true,
            "message"=>"Login Successful",
            "token"=>$token
        ]);

    } else {

        echo json_encode([
            "status"=>false,
            "message"=>"Invalid Password"
        ]);

    }

} else {

    echo json_encode([
        "status"=>false,
        "message"=>"User Not Found"
    ]);

}