
<?php
include "../../config/baseurl.php";
include "../../config/db.php";

$blog_id = $_GET["id"];

if (isset($_POST["title"]) && isset($_POST["category_id"]) && isset($_POST["description"]) &&
    strlen($_POST["title"]) > 0 && strlen($_POST["description"]) > 0) 
{

    $title = $_POST["title"];
    $category_id = $_POST["category_id"];
    $desc = $_POST["description"];
    $user_id = $_SESSION["id"];
    $file_name = "";
    $user_nickname = $_SESSION['nickname'];

    if (isset($_FILES["image"]) && strlen($_FILES["image"]["name"]) > 0) {
        $file_name = time() . ".";  // 15764.

        $exp = explode(".", $_FILES["image"]["name"]); // ["blog", "png"]

        $ext = end($exp); // png

        $file_name = $file_name . $ext; // 15764. + png  =>  15764.png

        move_uploaded_file($_FILES["image"]["tmp_name"], "../../images/blogs/$file_name");
    }

    if (strlen($file_name) > 0) {
        mysqli_query($con, "UPDATE blogs
                            SET title='$title', description='$desc', category_id=$category_id, image_name='$file_name' 
                            WHERE id=$blog_id");
    } else {
        mysqli_query($con, "UPDATE blogs
                            SET title='$title', description='$desc', category_id=$category_id 
                            WHERE id=$blog_id");
    }

    header("Location: $BASE_URL/profile.php?nickname=$user_nickname");

} else {
    header("Location: $BASE_URL/newblog.php?error=1");
}
?>