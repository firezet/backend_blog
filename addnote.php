<?php
// якщо залогінились
if(isset($_COOKIE["Username"])){
	// ініціалізація змінних
	$author = $_COOKIE["Username"];
	$title = $_POST["title"];
	$article = $_POST["article"];
	$date = date("Y-m-d");
// якщо не залогінились
} else header("Location:reg.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>
			Додаємо запис
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
				<li><a href=profile.php title=<?php echo "$author";?>>Профіль</a></li>
				<li><a href=exit.php>Вийти</a></li>
			</ul>
		</header>
		<div class="login_content">
			<?php
			$query = "insert into notes (author, title, article, created)
							values ('$author','$title','$article','$date');";							
			$link = mysqli_connect('127.0.0.1', 'root', 'root'); 
			mysqli_select_db($link, 'vii');
			//виконати запит: якщо не вдалося - вивести
			mysqli_query($link, $query)	or die("Не вдалося додати запис: " .mysql_error($link));
			// якщо вдалося - вивести
			echo "<p>Запис додано!</p>";
			?>
		</div>
		<footer><p>Made by viiper94 &copy; 2015</p></footer>
	</body>
</html>