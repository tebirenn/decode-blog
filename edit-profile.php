<?php
session_start();
include "config/baseurl.php";
include "config/db.php";

$user_id = $_SESSION["id"];

$profile_details_query = mysqli_query($con, "SELECT * FROM users WHERE id=$user_id");
$profile = mysqli_fetch_assoc($profile_details_query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Редактировать профиль</title>
	<?php include "views/head.php" ?>
</head>
<body>
<?php include "views/header.php" ?>

	<section class="container page">
		<div class="page-block">

			<div class="page-header">
				<h2>Редактировать профиль</h2>
			</div>
			<form class="form" action="<?=$BASE_URL?>/api/profile/update_profile.php" method="POST" enctype="multipart/form-data">
				
				<fieldset class="fieldset">
                    <p style="margin-bottom: 5px;">Ник</p>
					<input class="input" type="text" name="nickname" placeholder="Ник" value="<?=$profile['nickname']?>">
				</fieldset>

                <fieldset class="fieldset">
                    <p style="margin-bottom: 5px;">Полное имя</p>
					<input class="input" type="text" name="full_name" placeholder="Полное имя" value="<?=$profile['full_name']?>">
				</fieldset>

                <fieldset class="fieldset">
                    <p style="margin-bottom: 5px;">Почта</p>
					<input class="input" type="text" name="email" placeholder="Почта" value="<?=$profile['email']?>">
				</fieldset>

				<fieldset class="fieldset">
                    <p style="margin-bottom: 5px;">Фото профиля</p>
					<button class="button button-yellow input-file">
						<input type="file" name="image">	
						Выберите картинку
					</button>
				</fieldset>
					
				<fieldset class="fieldset">
                    <p style="margin-bottom: 5px;">Описание</p>
					<input class="input" type="text" name="description" placeholder="Описание" value="<?=$profile['description']?>">
				</fieldset>
				<fieldset class="fieldset">
					<button class="button" type="submit">Сохранить</button>
				</fieldset>
			</form>

		
		</div>

	</section>
	
</body>
</html>
