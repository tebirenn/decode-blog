<?php

session_start();
include "../../config/baseurl.php";
include "../../config/db.php";

if (isset($_POST["nickname"], $_POST["full_name"], $_POST["email"], $_POST["description"]) && 
    strlen($_POST["nickname"]) > 0 && strlen($_POST["full_name"]) > 0 && strlen($_POST["email"]) > 0 && strlen($_POST["description"]) > 0) {


    $user_id = $_SESSION["id"];
    $nickname = $_POST["nickname"];
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $description = $_POST["description"];

    $_SESSION["nickname"] = $nickname;
    $_SESSION["full_name"] = $full_name;
    $_SESSION["email"] = $email;
    $_SESSION["description"] = $description;

    if (isset($_FILES["image"]) && strlen($_FILES["image"]["name"]) > 0) {

        $file_name = time() . ".";  // 15764.
        $exp = explode(".", $_FILES["image"]["name"]); // ["avatar", "png"]
        $ext = end($exp); // png
        $file_name = $file_name . $ext; // 15764. + png  =>  15764.png
        move_uploaded_file($_FILES["image"]["tmp_name"], "../../images/avatars/$file_name");

        $_SESSION["image_name"] = $file_name;   

        mysqli_query($con, "UPDATE users
                            SET nickname='$nickname', full_name='$full_name', email='$email', description='$description', image='$file_name'
                            WHERE id=$user_id");
    } else {
        mysqli_query($con, "UPDATE users
                            SET nickname='$nickname', full_name='$full_name', email='$email', description='$description'
                            WHERE id=$user_id");
    }

    header("Location: $BASE_URL/profile.php");

} else {
    header("Location: $BASE_URL/edit-profile.php?error=1");
}

?>
