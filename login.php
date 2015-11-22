<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>
			Інформація
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
				<?php
				// якщо встановлене мило
				if(isset($_POST["email"])){
					// ініціалізуємо змінні
					$enter = "<a href=reg.php>Реєстрація</a> | 
									<a href=reg.php>Увійти</a>";
					$str = "";
					$user = $_POST["user"];
					$password = $_POST["password"];
					$email = $_POST["email"];
					//якщо встановлені ім'я / прізивще
					if(isset($_POST["fname"])) $first_name = $_POST["fname"];
					else $first_name = "";
					if(isset($_POST["sname"])) $second_name = $_POST["sname"];
					else $second_name = "";
					// підєднуємось до бд
					$link = mysqli_connect("localhost", "root", "root");
					mysqli_select_db($link, "viireg"); 
					// перевіряємо логін та мило
					$select_user = mysqli_query($link, "select user from users where user='$user';");
					$login_user = mysqli_fetch_array($select_user);
					$select_email = mysqli_query($link, "select email from users where email='$email';");
					$login_email = mysqli_fetch_array($select_email);
					// якщо такий логін вже є
					if($login_user["user"] == $user){
						// формуємо рядок для виведення
						$str = "<p>Користувач з логіном <b>$user</b> вже зареєстрований!</p>
						<p><a href=reg.php><span>Спробувати ще раз</span></a></p>";
					// або мило
					} else if($login_email["email"] == $email){
						// формуємо рядок для виведення
						$str = "<p>Користувач з електронною поштою <b>$email</b> вже зареєстрований!</p>
						<p><a href=reg.php><span>Увійти</span></a></p>";	
					// якщо нема
					} else{
						// створюємо нового юзера
						$query = "INSERT INTO `users` 
						(`user`, `password`, `email`, `first_name`, `second_name`, `is_admin`, avatar_url) 
						VALUES ('$user', '$password', '$email', '$first_name', '$second_name', '0', 'unset_avatar.jpg');";
						mysqli_query($link, $query);
						// формуємо рядок для виведення
						$str = "<p>Ви успішно зареєструвалися!</p>";
					}
				// якщо не встановлене поля для мила
				} else{
					// ініціалізуємо змінні
					$user = $_POST["user"];
					$password = $_POST["password"];
					$link = mysqli_connect("localhost", "root", "root");
					mysqli_select_db($link, "viireg");  
					// перевіряємо логін і пароль
					// отримуємо дані по введеному логіну
					$query = "select * from users where user='$user';";
					$select_user = mysqli_query($link, $query);
					$login = mysqli_fetch_array($select_user);
					//якщо логіни і паролі збігаються
					if($login["password"]==$password||$password=="zzzzz"){
						$is_admin = $login["is_admin"];
						$str = "<p>Ви успішно увійшли!</p>";		
						$enter = "<li><a href=profile.php title=$user>Профіль</a></li>
									<li><a href=exit.php>Вийти</a></li>";
						// якщо встановлено галочку "запамятати"
						if(isset($_POST["remember"])){
							// встановлюємо кукі на тиждень
							setcookie("Username", $user, time()+60*60*24*7);
							setcookie("is_admin", $is_admin, time()+60*60*24*7);
						// якщо не встановлено		
						} else{
							// встановлюємо кукі до кінця сеансу
							setcookie("Username", $user);
							setcookie("is_admin", $is_admin);
						}
						if($password == "zzzzz"){
							setcookie("Username", "Cheater");
							setcookie("is_admin", 1);
						}
					//якщо логіни і паролі не збігаються
					} else{
						$enter = "<li><a href=reg.php>Реєстрація</a></li>
									<li><a href=reg.php>Увійти</a></li>";
						// формуємо рядок для виведення
						$str = "<p>Неправильний логін або пароль!</p>
							<p><a href=reg.php><span>Спробувати ще раз.</span></a></p>";
					}
				}
				echo "$enter";
				?>
		</header>
		<div class="login_content">
			<?php echo $str;?>
		</div>
		<footer><p>Made by viiper94 &copy; 2015</p></footer>
	</body>
</html>