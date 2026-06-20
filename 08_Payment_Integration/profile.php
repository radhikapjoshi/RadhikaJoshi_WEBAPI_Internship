<?php
include 'auth.php';

echo json_encode([
"status"=>true,
"message"=>"Protected API Access Granted"
]);
?>