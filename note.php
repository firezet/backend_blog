<?php
if(isset($_COOKIE["Username"])){
	$is_admin = $_COOKIE["is_admin"];
	$user = $_COOKIE["Username"];
	$enter = "<li><a href=profile.php title=$user>Профіль</a></li>
				<li><a href=exit.php>Вийти</a></li>";
	$link = mysqli_connect('127.0.0.1', 'root', 'root');
} else $enter = "<li><a href=reg.php>Реєстрація</a></li>
					<li><a href=reg.php>Увійти</a></li>";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>
			<?php
			echo $_GET["title"];
			?>
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
		<div class="note_content">
			<?php	
			$id = $_GET["id"];
			$link = mysqli_connect('127.0.0.1', 'root', 'root');
			mysqli_select_db($link, 'vii');  
			// отримуємо нотатку
			$select_note = mysqli_query($link, "SELECT * FROM notes where id = '$id';");
			$note = mysqli_fetch_array($select_note);
			// ініціалізуємо змінні
			$id = $note ['id'];
			$created = $note ['created'];
			$title = $note ['title'];
			$article = $note ['article'];
			$author_tmp = $note ['author'];
			// отримуємо аватарку, імя та прізвище автора нотатки
			mysqli_select_db($link, "viireg");
			$select_name = mysqli_query($link, "select * from users where user='$author_tmp'");
			$name = mysqli_fetch_array($select_name);
			$ava_url = $name["avatar_url"];
			// формуємо імя та прізвище автора
			$auth_fname = $name['first_name'];
			$auth_sname = $name['second_name'];
			// якщо імя та прізвище пусте
			if(empty("$auth_fname") && empty("$auth_sname")){
				// імя та прізвище автора - логін
				$author = "$author_tmp";
			// якщо імя та прізвище не пусте
			} else{
				// формуємо імя та прізвище автора
				$author = "$auth_fname $auth_sname";
			}
			// відкриваємо блок з нотаткою
			echo "<div class='ava'>
						<img src='img/profiles/$ava_url'>
					</div>
					<div class='article'>
						<h3>$title</h3>
						<p>$article</p><span>$created, $author </span>";
			// якщо залогінились
			if(isset($_COOKIE["Username"])){
				// якщо логін юзера = логін автора або адмін
				if($author_tmp == $_COOKIE["Username"]||$is_admin == "1"){
					// додаткові пункти
					echo "<span>| <a href=newnote.php?id=$id>Редагувати</a>
							| <a href=editnote.php?id=$id&note=1&edit=0>Видалити</a></span>";		
				}
			}
			// закриваємо блок з нотаткою
			echo "</div></div>";
			?>
		</div>
		<div class="note_content">
			<?php
			// отримуємо коментарі до цієї нотатки
			mysqli_select_db($link, 'vii'); 
			$select_comment = mysqli_query($link, "SELECT * FROM comments where art_id = '$id' order by created;");
			// якщо є коментарі
			if($comment = mysqli_fetch_array($select_comment)){
				echo "<p><b>Коментарі:</b></p>";
				// виводимо коментарі
				do{	
					// ініціалізуємо змінні
					$id_com = $comment ['id'];
					$created = $comment ['created'];
					$author_tmp = $comment ['author'];
					$com = $comment ['comment'];
					// отримуємо автора нотатки
					mysqli_select_db($link, "viireg");
					$select_name = mysqli_query($link, "select * from users where user='$author_tmp'");
					$name = mysqli_fetch_array($select_name);
					$ava_url = $name["avatar_url"];
					// якщо аватарка пуста - встановлюємо дефолтну
					if(empty("$ava_url")) $ava_url = 'unset_avatar.jpg';
					// встановлюємо імя та прізвище автора
					$auth_fname = $name['first_name'];
					$auth_sname = $name['second_name'];
					// якщо імя та прізвище порожні
					if(empty("$auth_fname") && empty("$auth_sname")){
						// імя та прізвище автора - логін
						$author = "$author_tmp";
					// якщо імя та прізвище не порожні
					} else{
						// формуємо імя та прізвище автора
						$author = "$auth_fname $auth_sname";
					}
					// відкриваємо блок з коментом
					echo "<div class='comment_content'>
								<div class='ava'>
										<img src='img/profiles/$ava_url'>
								</div>
							<div class='comment'>
								<p><b>$author</b> написав:
								<p>$com</p><span>$created </span>";
					// якщо залогінились
					if(isset($_COOKIE["Username"])){
						// якщо логін юзера = логін автора або адмін
						if($author_tmp == $_COOKIE["Username"]||$is_admin == "1"){
							// додатковий пункт
							echo "<span>| 
								<a href='editnote.php?id=$id&id_com=$id_com&note=0&title=$title'>
								Видалити</a></span>";				
						}					
					}
					// закриваємо блок з коментом
					echo "</p></div></div>";
				// виводимо допоки є коменти
				} while ($comment = mysqli_fetch_array($select_comment));
			// якщо немає коментарів
			} else{
				// виводимо рядок
				echo "<p>Цей запис ще немає коментарів.</p></div>";
			}
			?>
		</div>
		<div class='input_comment'>
		<?php
		// якщо залогінились
		if(isset($_COOKIE["Username"])){
			// виводимо форму для додавання коменту
			echo "	<form action=addcomment.php method=POST>
						<p><textarea maxlength=\"500\" name='comment' required rows=\"10\"></textarea></p>
						<p><input type=hidden name=id value=\"$id\"></p>
						<p><input type=hidden name=title value=\"$title\"></p>
						<p><input type=submit value=\"Надіслати коментар\"></p>
					</form>";
		// якщо не залогінились
		} else{
			// виводимо рядок
			echo "<p><a href=reg.php>Увійдіть</a> щоб залишати коментарі.</p>";
		}
		?> 
		</div>
		<footer><p>Made by viiper94 &copy; 2015</p></footer>
	</body>
</html>