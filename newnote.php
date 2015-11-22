<?php
// якщо залогінились
if(isset($_COOKIE["Username"])){
	$user = $_COOKIE["Username"];
	$enter = "<li><a href=profile.php title=$user>Профіль</a></li>
				<li><a href=exit.php>Вийти</a></li>";
	// якщо редагувати існуючу нотатку
	if(isset($_GET["id"])){
		$id = $_GET["id"];
		$link = mysqli_connect('127.0.0.1', 'root', 'root');
		mysqli_select_db($link, "vii");
		// отримуємо заголовок і текст нотатки
		$select_note = mysqli_query($link, "select title, article from notes where id='$id';");
		$note = mysqli_fetch_array($select_note);
		$title = $note["title"];
		$article = $note["article"];
		// формуємо рядок для виведення
		$newnote = "<h3><b>Редагувати запис</b></h3>
				<h4>Заголовок:</h4>
				<form action=editnote.php method=POST>
					<input size=112 type=text maxlength=\"100\" name=title value='$title' 
					required placeholder=\"Про що йтиметься у вашому записі?\">
					<input type=hidden name=edit value=1>
					<input type=hidden name=note value=1>
					<input type=hidden name=id value=$id>
					<h4>Текст вашого запису:</h4>
					<textarea maxlength=\"12550\" name=article required rows=\"20\">$article</textarea>
					<p><input type=submit value=\"Редагувати запис\"></p>
				</form>";
	// якщо створити нову нотатку
	} else{
		// формуємо рядок для виведення
		$newnote = "<h3><b>Створити новий запис</b></h3>
				<form action=addnote.php method=POST>
					<h4>Заголовок:</h4>
					<input size=112 type=text maxlength=\"100\" name=title 
					required placeholder=\"Про що йтиметься у вашому записі?\">
					<h4>Текст вашого запису:</h4>
					<textarea maxlength=\"12550\" name=article required rows=\"20\"></textarea>
					<p><input type=submit value=\"Надіслати запис\"></p>
				</form>";
	}
// якщо не залогінились
} else{
	$enter = "<li><a href=reg.php>Реєстрація</a></li>
					<li><a href=reg.php>Увійти</a></li>";
	// формуємо рядок для виведення
	$newnote = "<p><b>Увійдіть, щоб додавати або редагувати нові записи!</b></p>
				<p><a href=reg.php><span>Увійти</span></a></p>";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>
			Додати запис
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
		<div class="login_content">
			<?php
			// виводимо рядок
			echo $newnote;
			?>
		</div>
		<footer><p>Made by viiper94 &copy; 2015</p></footer>
	</body>
</html>