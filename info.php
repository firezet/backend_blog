<?php
if(isset($_COOKIE["Username"])){
	$user = $_COOKIE["Username"];
	$enter = "<li><a href=profile.php title=$user>Профіль</a></li>
				<li><a href=exit.php>Вийти</a></li>";
} else $enter = "<li><a href=reg.php>Реєстрація</a></li>
					<li><a href=reg.php>Увійти</a></li>";
$link = mysqli_connect('127.0.0.1', 'root', 'root');
$db = mysqli_select_db($link, "vii"); 
// якщо вдалося підєднатися до бази
if ($db) {
	// отримуємо кількість нотаток
	$query = "select count(id) from notes";
	$all_notes = mysqli_fetch_row(mysqli_query($link, $query));
	// отримуємо кількість коментарів
	$query = "select count(id) from comments";
	$all_comments = mysqli_fetch_row(mysqli_query($link, $query));
	$date_array = getdate();
	// отримуємо сьогоднішню дату											
	$begin_date = date ("Y-m-d", mktime(0,0,0, $date_array['mon'],1,$date_array['year']));
	// отримуємо дату місяць тому
	$end_date = date ("Y-m-d", mktime(0,0,0, $date_array['mon'] + 1,0,$date_array['year']));
	// отримуємо кількість нотаток за останній місяць
	$query = "select count(id) from notes where created >='$begin_date' AND created <='$end_date'";
	$last_month_notes = mysqli_fetch_row(mysqli_query($link, $query));
	// отримуємо кількість коментарів за останній місяць
	$query = "select count(id) from comments where created >='$begin_date' AND created <='$end_date'";
	$last_month_comments = mysqli_fetch_row(mysqli_query($link, $query));
	// отримуємо назву останньої нотатки
	$query = "select title from notes order by created desc limit 1";
	$last_note = mysqli_fetch_array(mysqli_query($link, $query));
	// отримуємо назву нотатки, з найбільшою к-тю коментів	
	$query = "select notes.id, notes.title from comments, notes 
				where comments.art_id=notes.id group by notes.id 
				order by count(comments.id) desc limit 1;";	
	$most_popular_note = mysqli_fetch_array(mysqli_query($link, $query));
	// формуємо виведення
	$info = "<h4>Корисна інформація:</h4>
			<table>
				<tr>
					<td>Зроблено записів</td>
					<td class='table_php_out'>$all_notes[0]</td>
				</tr>
				<tr>
					<td>Коментарів</td>
					<td class='table_php_out'>$all_comments[0]</td>
				</tr>
				<tr>
					<td>Записів за останній місяць</td>
					<td class='table_php_out'>$last_month_notes[0]</td>
				</tr>
				<tr>
					<td>Коментарів за останній місяць</td>
					<td class='table_php_out'>$last_month_comments[0]</td>
				</tr>
				<tr>
					<td>Останній запис</td>
					<td class='table_php_out'>$last_note[0]</td>
				</tr>
				<tr>
					<td>Найпопулярніший запис</td>
					<td class='table_php_out'>$most_popular_note[1]</td>
				</tr>
				<tr>
			</table>";
// якщо не вдалося підєднатися
} else{
	$info = "Сталася помилка: " .mysqli_error($link);
}
?>
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
				<?php echo $enter;?>
			</ul>
		</header>
		<div class="reg_content">
			<?php echo $info;?>
		</div>
		<footer><p>Made by viiper94 &copy; 2015</p></footer>
	</body>
</html>