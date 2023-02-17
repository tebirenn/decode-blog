<!DOCTYPE html>
<html lang="en">
<head>
    <title>Войти в систему</title>
	<?php include "views/head.php" ?>
</head>
<body>
<?php include "views/header.php" ?>

	<section class="container page">
		<div class="auth-form">
            <h1>Вход</h1>
			<form class="form">
                <fieldset class="fieldset">
                    <input id="loginEmailInput" class="input" type="text" name="email" placeholder="Введите email">
                </fieldset>
                <fieldset class="fieldset">
                    <input id="loginPasswordInput" class="input" type="password" name="password" placeholder="Введите пароль">
                </fieldset>

                <fieldset class="fieldset">
                    <button id="authBtn" class="button" type="button">Войти</button>
                </fieldset>

                <p id="login-error" class="text-danger"></p>
    
			</form>
		</div>
	</section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="scripts/login_user.js"></script>
</body>
</html>