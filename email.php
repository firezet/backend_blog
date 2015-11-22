<?php
	$str = "";
	if(isset($_COOKIE["Username"])){
		$user = $_COOKIE["Username"];
		$enter = "<li><a href=profile.php title=$user>Профіль</a></li>
				<li><a href=exit.php>Вийти</a></li>";
	} else $enter = "<li><a href=reg.php>Реєстрація</a></li>
					<li><a href=reg.php>Увійти</a></li>";
	// якщо поле 'message' встановлене
	if(isset($_POST["message"])){
		// ініціалізуємо змінні
		$message = $_POST["message"];
		$subject = $_POST["subject"];
		$to = $_POST["email"];
		$headers = 'From: viiper94@gmail.com';
		// відправляємо ел. лист
		if(mail($to, $subject, $message, $headers)){
			$str = "Лист відпралено";
		} else{
			$str = "Лист не відпралено.";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel=stylesheet href=css/main.css>
	<title>Відправити електронного листа</title>
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
			<?php echo $enter;?>
		</ul>
	</header>
	<div class="login_content">
		<form action="email.php" method="POST">
			<?php echo $str; ?>
			<h3><b>Написати повідомлення</b></h3>
			<h4>Кому:</h4>
			<p><input size='112' type="email" name="email" required placeholder="E-Mail"></p>
			<h4>Тема:</h4>
			<p><input size='112' type="text" name="subject" placeholder="Тема"></p>
			<h4>Текст вашого листа:</h4>
			<p><textarea rows="20" name="message" required></textarea></p>
			<p><input type="submit" value="Надіслати"></p>
		</form>
	</div>
	<footer><p>Made by viiper94 &copy; 2015</p></footer>
</body>
</html>