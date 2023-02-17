<?php
session_start();
include "config/baseurl.php";
include "config/db.php";

$user_id = $_SESSION["id"];
$user_nickname = $_SESSION["nickname"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Профиль</title>
	<?php include "views/head.php" ?>
</head>
<body>

<?php include "views/header.php" ?>
<section class="container page">
	<div class="page-content">
		<div class="page-header">
			<h2>Мои блоги</h2>
			
			<a class="button" href="<?=$BASE_URL?>/newblog.php">Новый блог</a>

		</div>

		<div class="blogs">
			<?php
			$blogs_query = mysqli_query($con, "SELECT * FROM blogs WHERE user_id=$user_id ORDER BY created_at DESC");
			$blogs_count = mysqli_num_rows($blogs_query);

			if ($blogs_count == 0) {
				echo '<h2 class="text-info">У вас пока нет постов!</h2>';
			} else {
				while($row = mysqli_fetch_assoc($blogs_query)) {
			?>
			

				<div class="blog-item">
					<?php
						if (strlen($row["image_name"]) > 0) {
					?>
							<img class="blog-item--img" src="images/blogs/<?=$row['image_name']?>" alt="">

					<?php
						}
					?>
					
					<div class="blog-header">
						<h3><?=$row["title"]?></h3>
						<span class="link">
							<img src="<?=$BASE_URL?>/images/dots.svg" alt="">
							Еще

							<ul class="dropdown">
								<li> <a href="<?=$BASE_URL?>/editblog.php?id=<?=$row['id']?>">Редактировать</a> </li>
								<li> <a href="<?=$BASE_URL?>/api/blogs/delete_blog.php?id=<?=$row['id']?>" class="danger">Удалить</a> </li>
							</ul>
						</span>

					</div>
					<p class="blog-desc">
						<?=$row["description"]?>
					</p>

					<div class="blog-info">
						<span class="link">
							<img src="images/date.svg" alt="">
							<?=$row["created_at"]?>
						</span>
						<span class="link">
							<img src="images/visibility.svg" alt="">
							21
						</span>
						<a class="link" href="<?=$BASE_URL?>/blog-details.php?id=<?=$row['id']?>">
							<img src="images/message.svg" alt="">
							<?php
							$comments_query = mysqli_query($con, "SELECT * FROM comments WHERE blog_id=" . $row["id"]);
							echo mysqli_num_rows($comments_query);
							?>
						</a>
						<span class="link">
							<img src="images/forums.svg" alt="">
							<?php
							$category_id = $row["category_id"];
							$category_query = mysqli_query($con, "SELECT category_name FROM categories WHERE id=$category_id");
							$res = mysqli_fetch_assoc($category_query);
							echo $res["category_name"];
							?>
						</span>
						<a class="link">
							<img src="images/person.svg" alt="">

							<?php
							$user_nick_query = mysqli_query($con, "SELECT * FROM users WHERE id=" . $row['user_id']);
							$user_nick_query_res = mysqli_fetch_assoc($user_nick_query);
							echo $user_nick_query_res["nickname"];
							?>
							
						</a>
					</div>
				</div>
			<?php
				}
			}

			?>

		</div>
	</div>	
	<div class="page-info">
		<div class="user-profile">
			<img class="user-profile--ava" src="images/avatars/<?=$_SESSION['image_name']?>" alt="">

			<h1><?=$_SESSION["full_name"]?></h1>
			<h2><?=$_SESSION["description"]?></h2>
			<p><?=$blogs_count?> постов за все время</p>
			<a href="<?=$BASE_URL?>/edit-profile.php" class="button">Редактировать</a>
			<a href="<?=$BASE_URL?>/api/auth/logout.php" class="button button-danger"> Выход</a>
		</div>
	</div>
</section>	
</body>
</html>