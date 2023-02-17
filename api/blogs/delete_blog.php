<?php
include "../../config/baseurl.php";
include "../../config/db.php";

$blog_id = $_GET["id"];
mysqli_query($con, "DELETE FROM blogs WHERE id=$blog_id");
header("Location: $BASE_URL/profile.php");

?>