<?php
	// отримуємо логін юзера
	$login = $_COOKIE["Username"];
	//отримуємо дані юзера
	$link = mysqli_connect('127.0.0.1', 'root', 'root'); 
	mysqli_select_db($link, 'viireg');
	$select_user = mysqli_query($link, "select * from users where user='$login';");
	$user = mysqli_fetch_array($select_user);
	// ініціалізуємо змінні
	$old_password = $user["password"];
	$first_name = $user["first_name"];
	$second_name = $user["second_name"];
	$email = $user["email"];
	$birth_day = $user["birth_day"];
	$birth_month = $user["birth_month"];
	$birth_year = $user["birth_year"];
	$avatar_url = $user["avatar_url"];
	// якщо є параметр в url
	if(isset($_GET["wrong"])){
		// формуємо рядок
		switch ($_GET["wrong"]) {
			case '0':
				$info_string = "Зміни до профілю збережено!";
				break;
			case '1':
				$info_string = "Неправильний пароль!";
				break;
		}
	// якщо нема параметра
	} else{
		// формуємо рядок
		$info_string = "";
	}
?>
<!DOCTYPE html>
<html lang=en>
	<head>
		<meta charset=UTF-8>
		<title>
			Профіль
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
				<li><a href=profile.php title=<?php echo "$login";?>>Профіль</a></li>
				<li><a href=exit.php>Вийти</a></li>
			</ul>
		</header>
		<div class="profile_content">
			<p><?php echo $info_string;?></p>
			<div id="ava">
				<img src=img/profiles/<?php echo "$avatar_url";?>>
			</div>
			<form action="editprofile.php" method="post" enctype="multipart/form-data">
				<p><input id="file" type="file" name="filename" accept="image/*"></p>
				<p>Видалити зображення<input type="checkbox" name="delete_ava" id="box"></p>
				<table>
					<tr>
						<td>Логін</td>
						<td><input type="text" disabled value=<?php echo "$login";?>></td>
					</tr>
					<tr>
						<td>Поточний пароль</td>
						<td><input type="password" name="old_password"></td>
					</tr>
					<tr>
						<td>Новий пароль</td>
						<td><input type="password" name="new_password"></td>
					</tr>
					<tr>
						<td>Ім'я</td>
						<td><input type="text" name="first_name" value=<?php echo "$first_name";?>></td>
					</tr>
					<tr>
						<td>Прізвище</td>
						<td><input type="text" name="second_name" value=<?php echo "$second_name";?>></td>
					</tr>
					<tr>
						<td>Електронна пошта</td>
						<td><input type="email" name="email" value=<?php echo "$email";?>></td>
					</tr>
					<tr>
						<td>Дата народження</td>
						<td>
							<select name="birth_day">
								<option value="0" selected>День</option>
								<?php
									// генеруємо значення для списку "день"
									for ($i=1; $i <= 31; $i++){
										// якщо день народження юзера = поточному дню
										if($user["birth_day"] == $i){
											// додаємо обраний пункт
											echo "<option value=$i selected>$i</option>";
										// якщо не співпадає
										} else{
											// додаємо пункт
											echo "<option value=$i>$i</option>";
										}
									}
								?>
							</select>
							<select name="birth_month">
								<option value="0" selected>Місяць</option>";
								<?php
									// генеруємо значення для списку "місяць"
									for ($i=1; $i <= 12; $i++){ 
										// якщо місяць народження юзера = поточному місяцю
										if($user["birth_month"] == $i){
											// додаємо обраний пункт
											echo "<option value=$i selected>$i</option>";
										// якщо не співпадає
										} else{
											// додаємо пункт
											echo "<option value=$i>$i</option>";
										}
									}
								?>
							</select>
							<select name=birth_year>
								<option value="0" selected>Рік</option>";
								<?php
									// генеруємо значення для списку "рік"
									for ($i=2015; $i >= 1900; $i--){
										// якщо місяць народження юзера = поточному місяцю 
										if($user["birth_year"] == $i){
											// додаємо обраний пункт
											echo "<option value=$i selected>$i</option>";
										// якщо не співпадає
										} else{
											// додаємо пункт
											echo "<option value=$i>$i</option>";
										}
									}
								?>
							</select>
						</td>
					</tr>
				</table>
				<p><input type=submit value='Оновити профіль'></p>
			</form>
		</div>
		<footer><p>Made by viiper94 &copy; 2015</p></footer>
	</body>
</html>