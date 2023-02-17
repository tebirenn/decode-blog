<?php
    include "../../config/db.php";
    include "../../config/baseurl.php";

    if(isset($_POST["email"] , $_POST["full_name"], $_POST["nickname"] , 
        $_POST["password"] , $_POST["password2"]) && strlen($_POST["email"]) > 2 && 
        strlen($_POST["full_name"]) > 2 && strlen($_POST["nickname"]) > 2 &&
        strlen($_POST["password"]) > 2 && strlen($_POST["password2"]) > 2)
    {
        $email = $_POST["email"];
        $full_name = $_POST["full_name"];
        $nickname = $_POST["nickname"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];

        if($password != $password2){
            header("Location: $BASE_URL/register.php?error=2");
            exit();
        }

        $user_check = mysqli_query($con , "SELECT * FROM users WHERE email='$email' OR nickname='$nickname'");
        if(mysqli_num_rows($user_check) > 0){
            header("Location: $BASE_URL/register.php?error=3");
            exit();
        }

        $hash = sha1($password);
        mysqli_query($con ,"INSERT INTO users (email , full_name , nickname , password, description, image) 
                            VALUES ('$email' , '$full_name','$nickname' , '$hash', '', 'avatar.png');");
        header("Location: $BASE_URL/login.php");

    }else{
        header("Location: $BASE_URL/register.php?error=1");
    }