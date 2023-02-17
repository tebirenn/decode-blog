<?php
session_start();
include "../../config/db.php";
include "../../config/baseurl.php";

$email = $_POST["email"];
$password = $_POST["password"];


$user_query = mysqli_query($con , "SELECT * FROM users WHERE email='$email'");
if(mysqli_num_rows($user_query) == 0){
    $call_back_data = ["error" => 1];
    echo json_encode($call_back_data);
    exit();
}
$user = mysqli_fetch_assoc($user_query);

$hash = sha1($password);
if($user["password"] != $hash){
    $call_back_data = ["error" => 2];
    echo json_encode($call_back_data);
    exit();
}

$_SESSION["id"] = $user["id"];
$_SESSION["nickname"] = $user["nickname"];
$_SESSION["full_name"] = $user["full_name"];
$_SESSION["image_name"] = $user["image"];
$_SESSION["email"] = $user["email"];
$_SESSION["description"] = $user["description"];

$call_back_data = ["success" => true];
echo json_encode($call_back_data);

?>