<?php
    include "../../config/db.php";
    include "../../config/baseurl.php";

    if(isset($_POST["email"] , $_POST["password"]) &&
    strlen($_POST["email"]) > 2 && strlen($_POST["password"]) > 2){
        $email = $_POST["email"];
        $pass = $_POST["password"];

        $user_query = mysqli_query($con , "SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($user_query) <= 0){
            header("Location: $BASE_URL/login.php?error=2");
            exit();
        }
        $user = mysqli_fetch_assoc($user_query);
        // $user["email"] , $user["password"]
        $hash = sha1($pass);
        if($user["password"] != $hash){
            header("Location: $BASE_URL/login.php?error=3");
            exit();
        }
        session_start();
        $_SESSION["id"] = $user["id"];
        $_SESSION["nickname"] = $user["nickname"];
        $_SESSION["full_name"] = $user["full_name"];
        $_SESSION["image_name"] = $user["image"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["description"] = $user["description"];
        $nick = $user["nickname"];
        header("Location: $BASE_URL/profile.php?nickname=$nick");

    }else{
        header("Location: $BASE_URL/login.php?error=1");
    }