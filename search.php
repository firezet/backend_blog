<?php
	if(isset($_COOKIE["Username"])){
		$user = $_COOKIE["Username"];
		$enter = "<li><a href=profile.php title=$user>Профіль</a></li>
				<li><a href=exit.php>Вийти</a></li>";
	} else $enter = "<li><a href=reg.php>Реєстрація</a></li>
					<li><a href=reg.php>Увійти</a></li>";
	// отримуємо номер сторінки
	if(isset($_GET["page"])) $page = $_GET["page"];
	else $page = 1;
	$first_note_num = $page*10-10;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>
			Результат пошуку
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
			<p><b>Результат пошуку</b></p>
			<?php
				// отримуємо пошуковий запит
				$user_search = $_GET['search'];
				// формуємо початковий рядок
				$query = "SELECT * FROM notes";
				// заміняємо коми пробілами
				$clean_search = str_replace(',', ' ', $user_search);
				// розбиваємо рядок на масив за пробілами
				$search_words = explode(' ', $clean_search);
				// якщо кількість слів > 0
				if (count($search_words) > 0){
					// для кожного слова в масиві
					foreach($search_words as $word){
						// якщо не пусте
						if (!empty($word)){
							// записуємо в новий масив
							$final_search_words[] = $word;
						}
					}
				}
				// для кожного слова
				foreach($final_search_words as $word){
					// формуємо новий масив з частинами запиту
					$where_list[] = " article LIKE '%$word%' OR title LIKE '%$word%'";
				}
				// обєднуємо масив із частинами запиту через OR в рядок
				$where_clause = implode(' OR ', $where_list);
				// якщо рядок не пустий
				if (!empty($where_clause)){
					// додаємо до початкового рядка
					$query .=" WHERE $where_clause order by created desc, id desc limit $first_note_num, 10";
				}
				// виконуємо запит
				$link = mysqli_connect('127.0.0.1', 'root', 'root');
				mysqli_select_db($link, "vii");	
				$select_note = mysqli_query($link, $query);
				// якщо є результат
				if($note = mysqli_fetch_array($select_note)){
					// виводимо
					do{
						// ініціалізуємо змінні
						$id = $note ['id'];
						$created = $note ['created'];
						$title = $note ['title'];
						$full_article = $note ['article'];
						$author_tmp = $note ['author'];
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
						// отримуємо дані автора
						mysqli_select_db($link, "viireg");
						$select_name = mysqli_query($link, "select * from users 
												where user='$author_tmp'");
						$name = mysqli_fetch_array($select_name);
						$ava_url = $name["avatar_url"];
						// встановлюємо імя прізвище автора
						$auth_fname = $name['first_name'];
						$auth_sname = $name['second_name'];
						// якщо імя та прізвище автора пусті
						if(empty("$auth_fname") && empty("$auth_sname")){
							// імя прізвище - логін автора
							$author = "$author_tmp";
						// якщо не пусті
						} else{
							// формуємо імя прізвище автора
							$author = "$auth_fname $auth_sname";
						}
						// отримуємо к-тб коментів для нотатки
						mysqli_select_db($link, "vii");			
						$query = "select count(id) from comments where art_id='$id'";
						$comments = mysqli_fetch_row(mysqli_query($link, $query));
						// виводимо блок з нотаткою
						echo "<div class='main_note'>
									<div class='ava'>
										<img src='img/profiles/$ava_url'>
									</div>
								<div class='main_note_content'>
									<span class='main_author'>$created, $author</span>
									<span class='main_comments_num'><b>$comments[0]</b></span>
									<a href='note.php?id=$id&title=$title'><h3>$title</h3></a>
									<p>$article</p>
								</div></div>";
					// допоки є нотатки в результаті
					} while ($note = mysqli_fetch_array($select_note));
				// якщо немає результату
				} else {
					// виводимо блок
					echo "<div class='main_note'>
								<p>Нічого не знайдено.</p>
							</div>";
				}
			?>
		</div>
		<?php
			// отримуємо к-ть нотаток із результату
			$count = mysqli_fetch_row(mysqli_query($link, "SELECT COUNT(id) FROM notes WHERE $where_clause"));
			$notes_count = $count[0];
			// якщо к-ть > 10
			if($notes_count > 10){
				// відкриваємо блок з номерами сторінок
				echo "<div class='pages'><p>";
				for ($i=1; $i < $notes_count/10+1; $i++) {
					// якщо поточний номер сторінки збігається з ітерацією - виводимо жирним
					if($page == $i) echo "<a href='search.php?page=$i&search=$user_search'><b>$i</b></a>\t";
					// якщо ні - просто виводимо
					else echo "<a href='search.php?page=$i&search=$user_search'>$i</a>\t";
				}
			// закриваємо блок
			echo "</p></div>";
			}
		?>
		<footer><p>Made by viiper94 &copy; 2015</p></footer>
	</body>
</html>