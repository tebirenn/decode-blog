<?php
session_start();
include "config/db.php";
include "config/baseurl.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Добавление нового блога</title>
	<?php include "views/head.php" ?>
</head>
<body>
<?php include "views/header.php" ?>
	<section class="container page">
		<div class="page-block">

			<div class="page-header">
				<h2>Новый блог</h2>
			</div>
			<?php
			if (isset($_GET["error"]) && $_GET["error"] == 1) {
				echo '<p class="text-danger"> Заголовок или описание не могут быть пустыми!</p>';
			}
			?>
			
			<form class="form" action="<?=$BASE_URL?>/api/blogs/insert_blog.php" enctype="multipart/form-data" method="POST">
				
			<fieldset class="fieldset">
				<input class="input" type="text" name="title" placeholder="Заголовок">
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
				<textarea class="input input-textarea" name="description" id="" cols="30" rows="10" placeholder="Описание"></textarea>
			</fieldset>
			<fieldset class="fieldset">
				<button class="button" type="submit">Сохранить</button>
			</fieldset>
			</form>

		

		</div>

	</section>
	
</body>
</html>