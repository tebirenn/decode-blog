<?php
session_start();
include "config/baseurl.php";
include "config/db.php";

$blogs_per_page = 10;

if (isset($_GET["page"])) {
	$page = $_GET["page"];
} else {
	$page = 1;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Главная</title>
    <?php include "views/head.php" ?>
</head>
<body>
<?php include "views/header.php" ?>


<section class="container page">
	<div class="page-content">
		<h2 class="page-title">Блоги по программированию</h2>
		<p class="page-desc">Популярные и лучшие публикации по программированию для начинающих и профессиональных программистов и IT-специалистов.</p>

		<div class="blogs">
			<?php
			if (isset($_GET["category_id"])) {
				$category_id = $_GET["category_id"];
				$blogs_query = mysqli_query($con, "SELECT * FROM blogs WHERE category_id=$category_id ORDER BY created_at DESC LIMIT " . (($page-1)*10) . ", " . $blogs_per_page);

			} else if (isset($_POST["input-search"])) {
				$search_text = $_POST["input-search"];
				$blogs_query = mysqli_query($con, "SELECT * FROM blogs WHERE title LIKE '%$search_text%' OR description LIKE '%$search_text%' ORDER BY created_at DESC LIMIT " . (($page-1)*10) . ", " . $blogs_per_page);

			} else {
				$blogs_query = mysqli_query($con, "SELECT * FROM blogs ORDER BY created_at DESC LIMIT " . (($page-1)*10) . ", " . $blogs_per_page);

			}
			$blogs_count = mysqli_num_rows($blogs_query);

			if ($blogs_count == 0) {
				echo '<h2 class="text-info">Пока нет постов!</h2>';
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
						<?php
						if (isset($_SESSION["id"]) && $row["user_id"] == $_SESSION["id"]) {
						?>
						<a class="profile-link link" href="<?=$BASE_URL?>/profile.php">
						<?php
						} else {
						?>
						<a class="profile-link link" href="<?=$BASE_URL?>/other-profile.php?id=<?=$row['user_id']?>">
						<?php
						}
						?>
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

		<div class="pages-nav">
			<?php
			if (isset($_GET["category_id"])) {
				$category_id = $_GET["category_id"];
				$all_blogs_query = mysqli_query($con, "SELECT * FROM blogs WHERE category_id=$category_id ORDER BY created_at DESC");

			} else if (isset($_POST["input-search"])) {
				$search_text = $_POST["input-search"];
				$all_blogs_query = mysqli_query($con, "SELECT * FROM blogs WHERE title LIKE '%$search_text%' OR description LIKE '%$search_text%' ORDER BY created_at DESC");

			} else {
				$all_blogs_query = mysqli_query($con, "SELECT * FROM blogs ORDER BY created_at DESC");
			}

			$blogs_count = mysqli_num_rows($all_blogs_query);
			for ($i = 1; $i <= ceil($blogs_count / $blogs_per_page); $i++) {

				if ($page == $i) {

					if (isset($_GET["category_id"])) {
						echo '<a href="'. $BASE_URL . '/?page='. $i .'&category_id='. $category_id .'" class="pages-nav-btn pages-nav-btn-active">'. $i .'</a>';
					} else if (isset($_POST["input-search"])) {
			?>
						<form action="<?=$BASE_URL?>/?page=<?=$i?>" method="POST">
							<input class="hide-input" type="text" name="input-search" id="" value="<?=$_POST['input-search']?>">
							<button type="submit" class="pages-nav-btn pages-nav-btn-active">
								<?=$i?>
							</button>
						</form>
			<?php
					} else {
						echo '<a href="'. $BASE_URL . '/?page='. $i .'" class="pages-nav-btn pages-nav-btn-active">'. $i .'</a>';
					}
					
				} else {
					if (isset($_GET["category_id"])) {
						echo '<a href="'. $BASE_URL . '/?page='. $i .'&category_id='. $category_id .'" class="pages-nav-btn">'. $i .'</a>';
					} else if (isset($_POST["input-search"])) {
			?>
						<form action="<?=$BASE_URL?>/?page=<?=$i?>" method="POST">
							<input class="hide-input" type="text" name="input-search" id="" value="<?=$_POST['input-search']?>">
							<button type="submit" class="pages-nav-btn">
								<?=$i?>
							</button>
						</form>
			<?php
					} else {
						echo '<a href="'. $BASE_URL . '/?page='. $i .'" class="pages-nav-btn">'. $i .'</a>';
					}
				}
				
			}
			?>
		</div>
	</div>



	<div class="categories">
		<h1 class="text-info-big">Категории</h1>

		<?php
		$categories_query = mysqli_query($con, "SELECT * FROM categories");
		while ($row = mysqli_fetch_assoc($categories_query)) {
			$ctgr_name =  $row["category_name"];
			if (isset($_GET["category_id"]) && $row["id"] == $_GET["category_id"]) {

				echo '<a class="picked-link" href="' .$BASE_URL . '/?category_id=' . $row["id"] . '">' . $ctgr_name . '</a>';

			} else {

				echo '<a class="text-link" href="' .$BASE_URL . '/?category_id=' . $row["id"] . '">' . $ctgr_name . '</a>';

			}
		
		}
		?>
		
	</div>
</section>	


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</body>
</html>


<!-- 
<form action="index/page" method="POST">
	<input type="text" name="input-search" id="" value>
	<button type="submit">$i</button>
</form> -->