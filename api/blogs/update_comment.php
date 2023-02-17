<?php
session_start();
include "../../config/baseurl.php";
include "../../config/db.php";

$comment_id = $_GET["id"];

$blog_id_query = mysqli_query($con, "SELECT blog_id FROM comments WHERE id=$comment_id");
$blog_id = mysqli_fetch_assoc($blog_id_query)["blog_id"];

if (isset($_POST["text"]) && strlen($_POST["text"]) > 0) {
    $text = $_POST["text"];

    mysqli_query($con, "UPDATE comments
                        SET text='$text'
                        WHERE id=$comment_id");

    header("Location: $BASE_URL/blog-details.php?id=$blog_id");

} else {
    header("Location: $BASE_URL/blog-details.php?id=$blog_id&comment_id=$comment_id&error=1");
}
?>