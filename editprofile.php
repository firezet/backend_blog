<?php
	// ініціалізація змінних юзер, мило, ім'я, прізвище, дата народження
	$user = $_COOKIE["Username"];
	$email = $_POST["email"];
	$first_name = $_POST["first_name"];
	$second_name = $_POST["second_name"];
	$birth_day = $_POST["birth_day"];
	$birth_month = $_POST["birth_month"];
	$birth_year = $_POST["birth_year"];
	$upd_ava = "";
	$link = mysqli_connect("localhost", "root", "root");
	mysqli_select_db($link, "viireg");
	// якщо був завантажений файл
	if(is_uploaded_file($_FILES["filename"]["tmp_name"])){
		// видаляємо стару аватарку з сервера
		$select_ava = mysqli_query($link, "select avatar_url from users where user='$user';");
		$ava_arr = mysqli_fetch_array($select_ava);
		$ava_url = $ava_arr['avatar_url'];
		unlink("img/profiles/$ava_url");
		// переміщаємо файл з tmp-директорії до вказаної папки на сервері
		move_uploaded_file($_FILES["filename"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].
	     					"/blog/img/profiles/"."$user.jpg");
		$file_name = "$user.jpg";
		$upd_ava = ", avatar_url='$file_name'";
 	}
 	// якщо встановлена галочка для видалення зображення
  	if(isset($_POST["delete_ava"])){
  		// видаляємо аватарку з сервера
  		$select_ava = mysqli_query($link, "select avatar_url from users where user='$user';");
		$ava_arr = mysqli_fetch_array($select_ava);
		$ava_url = $ava_arr['avatar_url'];
		unlink("img/profiles/$ava_url");
		// встановлюємо дефолтну аватарку
  		$upd_ava = ", avatar_url='unset_avatar.jpg'";
  	}
	// якщо вказаний новий пароль - перевіряємо: чи співпадає із старим?
	if($_POST["new_password"] !== ""){
		// отримуємо старий пароль
		$old_password = $_POST["old_password"];
		$select_pass = mysqli_query($link, "select password from users where user='$user';");
		$password = mysqli_fetch_array($select_pass);
		// якщо співпадає - встановлюємо новий пароль
		if($old_password == $password["password"]){			
			$new_password = $_POST["new_password"];
			$get = "wrong=0";
		// якщо не співпадає - встановлюємо старий пароль
		} else{
			$new_password = $password["password"];
			$get = "wrong=1";
		}
		$upd_pass = ", password='$new_password'";
	// якщо не вказаний
	} else{
		$upd_pass = "";
		$get = "wrong=0";
	}
	// оновлюємо дані
	$query = "update users set email='$email', first_name='$first_name',
				second_name='$second_name', birth_day='$birth_day',
				birth_month='$birth_month',
				birth_year='$birth_year'
				$upd_ava
				$upd_pass where user='$user'";
	mysqli_query($link, $query);
	// повертаємо на сторінку профілю
	header("Location:profile.php?$get");
?>