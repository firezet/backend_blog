<?php
	if(isset($_COOKIE["Username"])){
		$user = $_COOKIE["Username"];
		$enter = "<li><a href=profile.php title=$user>Профіль</a></li>
				<li><a href=exit.php>Вийти</a></li>";
	} else $enter = "<li><a href=reg.php>Реєстрація</a></li>
					<li><a href=reg.php>Увійти</a></li>";
	// визначаємо номер сторінки
	if(isset($_GET["page"])) $page = $_GET["page"];
	else $page = 1;
	$first_note_num = $page*10-10;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>
			Бложик
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
		<div class="main_content">
			<div class="main_intro">
				<h3>Цей блог присвячений нічому...<br>Тут можна розповідати ні про що...</h3>
			</div>
			<div class="main_search">
				<form action="search.php" method="GET">
					<input type="text" name="search" placeholder="Пошук">
				</form>
			</div>	
		</div>	
		<div class="main_content">
			<?php
				// отримуємо 10 нотаток
				$link = mysqli_connect('127.0.0.1', 'root', 'root') or die ("База даних не працює :(");
				mysqli_select_db($link, "vii");	
				$query = "SELECT * from notes order by created desc, id desc limit $first_note_num, 10";		
				$select_note = mysqli_query($link, $query);
				while ($note = mysqli_fetch_array($select_note)){
					// виводимо параметри нотатки
					$id = $note ['id'];
					$created = $note ['created'];
					$title = $note ['title'];
					$full_article = $note ['article'];
					// перевіряємо довжину нотатки
					// якщо більше 500 символів
					if(strlen($full_article)>500){
						// ріжемо, додаємо посилання
						$article = substr($full_article, 0, 500).
									"... <p><a href='note.php?id=$id&title=$title'><b>Читати далі</b></a></p>";
					// якщо коротше 500 символів
					} else{
						$article = $full_article;
					}
					$author_tmp = $note["author"];
					// отримуємо аватарку юзера
					mysqli_select_db($link, "viireg");
					$select_name = mysqli_query($link, "SELECT * from users 
											where user='$author_tmp'");
					$name = mysqli_fetch_array($select_name);
					$ava_url = $name["avatar_url"];
					// отримуємо ім'я та призвіще
					$auth_fname = $name['first_name'];
					$auth_sname = $name['second_name'];
					// якщо обидва пусті
					if(empty("$auth_fname") && empty("$auth_sname")){
						// встановлюємо автора - логін
						$author = "$author_tmp";
					} else{
						//встановлюємо автора - його ім'я та прізвище
						$author = "$auth_fname $auth_sname";
					}
					// отримуємо к-ть коментів до нотатки
					mysqli_select_db($link, "vii");
					$querry = "SELECT count(id) from comments where art_id='$id'";
					$comments = mysqli_fetch_row(mysqli_query($link, $querry));
					// виводимо блок з нотаткою
					echo 	"<div class='main_note'>
								<div class='ava'>
									<img src='img/profiles/$ava_url'>
								</div>
								<div class='main_note_content'>
									<span class='main_author'>$created, $author</span>
									<span class='main_comments_num'><b>$comments[0]</b></span>
									<a href='note.php?id=$id&title=$title'><h3>$title</h3></a>
									<p>$article</p>
								</div>
							</div>";
				}
			?>
		</div>
		<?php
			// отримуємо загальну кількість нотаток
			$count = mysqli_fetch_row(mysqli_query($link, "SELECT COUNT(id) FROM notes"));
			$notes_count = $count[0];
			// якщо к-ть > 10
			if($notes_count > 10){
				// відкриваємо блок з номерами сторінок
				echo "<div class='pages'><p>";
				for ($i=1; $i < $notes_count/10+1; $i++) {
					// виводимо номера сторінок
					// якщо поточна сторінка = номеру виводимого номеру, то жирним
					if($page == $i) echo "<a href='index.php?page=$i'><b>$i</b></a>\t";
					// якщо !=, просто вивести номер
					else echo "<a href='index.php?page=$i'>$i</a>\t";
				}
			// закриваємо блок
			echo "</p></div>";
			}
		?>
		<footer><p>Made by viiper94 &copy; 2015</p></footer>
	</body>
</html>