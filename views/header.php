<?php 
include "config/baseurl.php";
include "config/db.php";
?>
<header class="header container">
	<div class="header-logo">
	    <a href="<?=$BASE_URL?>">Decode Blog</a>	
	</div>
	<form class="header-search" action="<?=$BASE_URL?>/index.php" method="POST">

		<fieldset class="fieldset">
			<input type="text" name="input-search" class="input-search" placeholder="Поиск по блогам">
		</fieldset>

		<fieldset class="fieldset">
			<button class="button button-search" type="submit">
				<img src="images/search.svg" alt="">	
				Найти
			</button>
		</fieldset>

	</form>
	<div>
		
        <!-- <a href="">
            <img class="avatar" src="images/avatar.png" alt="Avatar">
        </a> -->

        <div class="button-group">
			<?php
			if (isset($_SESSION["id"])) {
				$image_name = $_SESSION["image_name"];
			?>
				<a href="<?=$BASE_URL?>/profile.php">
					<img class="avatar" src="<?=$BASE_URL?>/images/avatars/<?=$image_name?>" alt="">
				</a>
			<?php
			} else {
			?>
				<a href="<?=$BASE_URL?>/register.php" class="button">Регистрация</a>
				<a href="<?=$BASE_URL?>/login.php" class="button">Вход</a>
			<?php
			}
			?>
        </div>

		
	</div>
</header>