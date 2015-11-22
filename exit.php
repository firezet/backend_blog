<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>
			Реестрація
		</title>
		<link rel=stylesheet href=css/main.css>
	</head>
	<body>
		<header>
			<ul>
				<li><a href=index.php>Головна сторінка</a></li>
				<li><a href=newnote.php>Новий запис</a></li>
				<li><a href=email.php>Відправити повідомлення</a></li> 
				<li><a href=index.php>Фото</a></li>
				<li><a href=index.php>Файли</a></li>
				<li><a href=info.php>Інформація</a></li>
				<li><a href=reg.php>Реєстрація</a></li>
				<li><a href=reg.php>Увійти</a></li>
			</ul>
		</header>
		<div class="login_content">
			<?php
			// обнуляємо кукі
			setcookie("Username", "");
			setcookie("is_admin", "");
			// виводимо рядок
			echo "<p>Ви вийшли із системи.</p>";
			?>
		</div>
		<footer><p>Made by viiper94 &copy; 2015</p></footer>
	</body>
</html>