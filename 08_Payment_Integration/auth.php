<?php
include '../db.php';
$headers=getallheaders();

if(!isset($headers['Authorization'])){
echo json_encode(["status"=>false,"message"=>"Token Missing"]);
exit;
}

$token=str_replace("Bearer ","",$headers['Authorization']);

$q=mysqli_query($conn,"SELECT id FROM users WHERE api_token='$token'");

if(mysqli_num_rows($q)==0){
echo json_encode(["status"=>false,"message"=>"Unauthorized"]);
exit;
}
?>