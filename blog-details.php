<?php
session_start();
include "config/baseurl.php";
include "config/db.php";

$id = $_GET["id"];
$blog_details_query = mysqli_query($con, "SELECT * FROM blogs WHERE id=$id");
$blog_details = mysqli_fetch_assoc($blog_details_query);


$comments_query = mysqli_query($con, "SELECT * FROM comments WHERE blog_id=$id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Профиль</title>
    <?php include "views/head.php" ?>
</head>
<body>
<?php include "views/header.php" ?>

<section class="blog-details-page container page">
	<div class="page-content">
		<div class="blogs">
			<div class="blog-item">
				<img class="blog-item--img" src="<?=$BASE_URL?>/images/blogs/<?=$blog_details['image_name']?>" alt="">

                <div class="blog-info">
					<span class="link">
						<img src="images/date.svg" alt="">
						<?=$blog_details["created_at"]?>
					</span>
					<span class="link">
						<img src="images/visibility.svg" alt="">
						21
					</span>
					<a class="link">
						<img src="images/message.svg" alt="">
						<?=mysqli_num_rows($comments_query)?>
					</a>
					<span class="link">
						<img src="images/forums.svg" alt="">
						<?php
						$category_query = mysqli_query($con, "SELECT category_name FROM categories WHERE id=$id");
						$category_query_result = mysqli_fetch_assoc($category_query);
						echo $category_query_result["category_name"];
						?>
					</span>
					<a class="link">
						<img src="images/person.svg" alt="">
						<?php
						// $nickname_query = mysqli_query($con, "SELECT nickname FROM users WHERE id=" . $blog_details["user_id"]);
						// $nickname_result = mysqli_fetch_assoc($nickname_query);
						// echo $nickname_result["nickname"];
						echo mysqli_fetch_assoc(mysqli_query($con, "SELECT nickname FROM users WHERE id=" . $blog_details["user_id"]))["nickname"]; 
						?>
					</a>
				</div>

				<div class="blog-header">
					<h3><?=$blog_details["title"]?></h3>
				</div>
				<p class="blog-desc">
					<?=$blog_details["description"]?>
				</p>
			</div>
		</div>

        <div class="comments">
            <h2>
                Комментарий: <?=mysqli_num_rows($comments_query)?>
            </h2>

			<?php 
			if (mysqli_num_rows($comments_query) == 0) {
				echo '<p class="text-info" style="margin: 5px 0;">Пока нет комментариев!</p>';
			} else {
				while ($row = mysqli_fetch_assoc($comments_query)) {
					$profile_query = mysqli_query($con, "SELECT full_name, image FROM users WHERE id=" . $row["user_id"]);
					$profile = mysqli_fetch_assoc($profile_query);
					$full_name = $profile["full_name"];
					$image_name = $profile["image"];
			?>
					<div class="comment">
						<div class="comment-header">
							<span>
								<img src="<?=$BASE_URL?>/images/avatars/<?=$image_name?>" alt="">
								<?=$full_name?>
							</span>

							<?php
							if ($_SESSION["id"] == $row["user_id"]) {
							?>
								<span class="link">
									<img src="<?=$BASE_URL?>/images/dots.svg" alt="">
									Еще

									<ul class="dropdown">
										<li> <a href="<?=$BASE_URL?>/blog-details.php?id=<?=$row['blog_id']?>&comment_id=<?=$row['id']?>">Редактировать</a> </li>
										<li> <a href="<?=$BASE_URL?>/api/blogs/delete_comment.php?id=<?=$row['id']?>" class="danger">Удалить</a> </li>
									</ul>
								</span>
							<?php
							}
							?>
						</div>
						<p>
						<?=$row["text"]?>
						</p>
					</div>

					
			<?php

				}
			}
			?>

			<?php
			if (isset($_SESSION["id"]) && isset($_GET["comment_id"])) {
				$comment_id = $_GET["comment_id"];
				$comment_details_query = mysqli_query($con, "SELECT * FROM comments WHERE id=$comment_id");
				$comment_details = mysqli_fetch_assoc($comment_details_query);
			?>
				<form class="comment-add" action="<?=$BASE_URL?>/api/blogs/update_comment.php?id=<?=$comment_id?>" method="POST">
					<textarea name="text" class="comment-textarea" placeholder="Введит текст комментария"><?=$comment_details["text"]?></textarea>
					<?php 
					if (isset($_GET["error"]) && $_GET["error"] == 1) {
						echo '<p class="text-danger">Заполните поле!</p>';
					}
					?>
					<button class="button" style="margin-top: 10px;">Отправить</button>
				</form>
			<?php
			}
			else if (isset($_SESSION["id"])) {
			?>
				<form class="comment-add" action="<?=$BASE_URL?>/api/blogs/add_comment.php?blog_id=<?=$blog_details['id']?>" method="POST">
					<textarea name="text" class="comment-textarea" placeholder="Введит текст комментария"></textarea>
					<?php 
					if (isset($_GET["error"]) && $_GET["error"] == 1) {
						echo '<p class="text-danger">Заполните поле!</p>';
					}
					?>
					<button class="button" style="margin-top: 10px;">Отправить</button>
				</form>
			<?php
			} else {
			?>
				<span class="comment-warning">
					Чтобы оставить комментарий <a href="<?=$BASE_URL?>/register.php">зарегистрируйтесь</a> , или  <a href="<?=$BASE_URL?>/login.php">войдите</a>  в аккаунт.
				</span>
			<?php
			}
			?>
        

        </div>
	</div>
	
</section>	
</body>
</html>