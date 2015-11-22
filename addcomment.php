<?php
// якщо залогінились
if(isset($_COOKIE["Username"])){
	// отримуємо змінні
	$author = $_COOKIE["Username"];
	$comment = $_POST["comment"];
	$id = $_POST["id"];
	$title = $_POST["title"];
	$date = date("Y-m-d");
// якщо не залогінились - на головну
} else header("Location:main.php"); 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="UTF-8">
		<title>
			От халепонька :(
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
		<div class="reg_content">
			<?php
			// Виведення результату
			$link = mysqli_connect('127.0.0.1', 'root', 'root');
			$query = "insert into comments (author, comment, created, art_id)
							values ('$author','$comment','$date','$id');";
			mysqli_select_db($link, 'vii');
			//виконати запит: якщо не вдалося - вивести
			mysqli_query($link, $query)	or die("Не вдалося додати коментар<br> 
										<a href=note.php?id=$id&title=$titleНазад</a>"); 
			// якщо вдалося - заново завантажити сторінку з нотаткою
			header("Location:note.php?id=$id&title=$title"); 
			?>
		</div>
		<footer><p>Made by viiper94 &copy; 2015</p></footer>
		</td></tr>
		</table>
	</body>	
</html>