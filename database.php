<?php
if(isset($_COOKIE["Username"])){
	$user = $_COOKIE["Username"];
	$enter = "<li><a href=profile.php title=$user>Профіль</a></li>
				<li><a href=exit.php>Вийти</a></li>";
	$is_admin = $_COOKIE["is_admin"];
} else{
	$enter = "<li><a href=reg.php>Реєстрація</a></li>
					<li><a href=reg.php>Увійти</a></li>";
	$user = "";
	$is_admin = "";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>
			Створення БД
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
				<?php echo $enter;?>
			</ul>
		</header>
		<div class="input_comment">
			<?php
			if ($is_admin == "1"){
				$link = mysqli_connect('127.0.0.1', 'root', 'root') 
				or die("<p>Не вдається встановити з'єднання: " . mysqli_error($link)); 
				echo "<p>З'єднання з сервером встановлено.</p>";
				echo "<form action=\"database.php\" method=\"post\">
						<p><input type=\"text\" name=\"db\" required placeholder=\"Назва нової бази даних\"><br>
						<input type=\"submit\" name=\"dbcreate\" value=\"Створити нову базу даних\"></p>
						</form>
						<p><form action=\"database.php\" method=\"post\">
						<input type=\"text\" name=\"username\" required placeholder=\"Ім'я користувача\"><br>
						<input type=\"password\" name=\"password\" required placeholder=\"Пароль користувача\"><br>
						<input type=\"submit\" name=\"usercreate\" value=\"Створити нового юзера\"></p>
						</form>
						<p><form action=\"database.php\" method=\"post\">
						<input type=\"text\" name=\"db1\" required placeholder=\"Назва існуючої бази даних\"><br>
						<input type=\"text\" name=\"ftable\" placeholder=\"Назва таблиці з нотатками\"><br>
						<input type=\"text\" name=\"stable\" placeholder=\"Назва таблиці з коментарями\"><br>
						<input type=\"submit\" name=\"usercreate\" value=\"Створити нові таблиці\"></p>
					</form>";
				if (isset($_POST["db"])){
					$db = $_POST["db"]; 
					$query = "CREATE DATABASE $db"; 
					mysqli_query($link, $query) 
					or die("Не вдалося створити БД: " .mysqli_error($link));
					echo "<p>Базу даних $db створено!</p>";
				}
				if (isset($_POST["username"])&&isset($_POST["password"])){
					$username = $_POST["username"]; 
					$password = $_POST["password"]; 
					$query = "GRANT ALL PRIVILEGES ON *.* TO '$username'@'localhost'
					IDENTIFIED BY '$password' WITH GRANT OPTION"; 
					mysqli_query($link, $query) 
					or die("Не вдалося створити нового користувача: " . mysqli_error($link));
					echo "<p>Користувача $username створено!</p>";
				}
				if(isset($_POST["db1"])){	
					$db1 = $_POST["db1"];
					$ftable = $_POST["ftable"];
					$stable = $_POST["stable"]; 
					mysqli_select_db($link, $db1) 
					or die("Не вдалося обрати базу даних $db1: " . mysqli_error($link));
					if($ftable != ""){		
						$query = "CREATE TABLE $ftable
						(id INT NOT NULL AUTO_INCREMENT,
						PRIMARY KEY (id),
						created DATE,
						title VARCHAR (100),
						article VARCHAR (12550),
						author VARCHAR (50))";
						mysqli_query ($link, $query)
						or die("Таблиця $ftable не створена: " . mysqli_error($link));
						echo "<p>Таблиця $ftable успішно створена.</p>";
					}
					if($stable != ""){			
						$query = "CREATE TABLE $stable
						(id INT NOT NULL AUTO_INCREMENT,
						created DATE NOT NULL,
						author VARCHAR(50) NOT NULL,
						comment VARCHAR(500),
						art_id SMALLINT(6) NOT NULL,
						PRIMARY KEY (id));";
						mysqli_query ($link, $query)
						or die("Таблиця $stable не створена: " . mysqli_error($link));
						echo "<p>Таблиця $stable успішно створена.</p>";
					}
				}
			} else {
				echo "<p>Ви не маєте доступу до бази даних! Зверніться до адміністратора.</p>";
			}
			?>
		</div>
		<footer><p>Made by viiper94 &copy; 2015</p></footer>
	</body>
</html>