<?php
session_start();
include "config/baseurl.php";
include "config/db.php";

$blog_id = $_GET["id"];

$blog_data_query = mysqli_query($con, "SELECT * FROM blogs WHERE id=$blog_id");
$blog_data = mysqli_fetch_assoc($blog_data_query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Редактировать блог</title>
	<?php include "views/head.php" ?>
</head>
<body>
<?php include "views/header.php" ?>

	<section class="container page">
		<div class="page-block">

			<div class="page-header">
				<h2>Редактировать блог</h2>
			</div>
			<form class="form" action="<?=$BASE_URL?>/api/blogs/update_blog.php?id=<?=$blog_id?>" method="POST" enctype="multipart/form-data">
				
				<fieldset class="fieldset">
					<input class="input" type="text" name="title" placeholder="Заголовок" value="<?=$blog_data['title']?>">
				</fieldset>

				<fieldset class="fieldset">
				<select name="category_id" id="" class="input">
					<?php
					$all_categories_query = mysqli_query($con, "SELECT * FROM categories");
					while ($row = mysqli_fetch_assoc($all_categories_query)) {
						echo '<option value="' . $row["id"] . '">' . $row["category_name"] . '</option>';
					}
					?>
				</select>
			</fieldset class="fieldset">

				<fieldset class="fieldset">
					<button class="button button-yellow input-file">
						<input type="file" name="image">	
						Выберите картинку
					</button>
				</fieldset>
					
				<fieldset class="fieldset">
					<textarea class="input input-textarea" name="description" id="" cols="30" rows="10" placeholder="Описание"><?=$blog_data["description"]?></textarea>
				</fieldset>
				<fieldset class="fieldset">
					<button class="button" type="submit">Сохранить</button>
				</fieldset>
			</form>

			
				<!-- <p class="text-danger"> Заголовок и Описание не могут быть пустыми!</p> -->



		</div>

	</section>
	
	

	
	
</body>
</html>
