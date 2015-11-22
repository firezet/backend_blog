<?php
	// отримуємо id нотатки/коменту
	if(isset($_GET["id"])) $id = $_GET["id"];
	else $id = $_POST["id"];
	if(isset($_GET["id_com"])){
		$id_com = $_GET["id_com"];
		$title = $_GET["title"];
	}
	// перевірка: комент або нотатка?
	if(isset($_GET["note"])) $note = $_GET["note"];
	else $note = $_POST["note"];
	$link = mysqli_connect('127.0.0.1', 'root', 'root');
	mysqli_select_db($link, "vii");  
	// якщо комент - видаляємо
	if($note == "0"){
		//видаляємо комент
		$query = "DELETE from comments where id='$id_com';";
		mysqli_query($link, $query) or die (mysqli_error($link));
		// повертаємо на сторінку нотатки
		header("Location:note.php?id=$id&title=$title");
	// якщо нотатка - перевіряємо редагувати чи видалити?
	} else if($note == "1"){
		// якщо редагувати - редагуємо
		if(isset($_POST["edit"])){
			$title = $_POST["title"];
			$article = $_POST["article"];
			// виконуємо запит
			$query = "UPDATE notes set title='$title', article='$article' where id='$id';";
			mysqli_query($link, $query) or die (mysqli_error($link));
			// якщо успішно - повертаємо на сторінку нотатки
			header("Location:note.php?id=$id&title=$title");
		// якщо видалити - видаляємо
		} else if($_GET["edit"] == "0"){
			// видаляємо нотатку
			$query = "DELETE from notes where id='$id';";
			mysqli_query($link, $query) or die (mysqli_error($link));
			// видаляємо коментарі нотатки
			$query = "DELETE from comments where art_id='$id';";
			mysqli_query($link, $query) or die (mysqli_error($link));
			// якщо успішно - повертаємо на головну сторінку
			header("Location:index.php");
		}
	}
?>