<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>
			Реестрація
		</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
		<link rel=stylesheet href=css/style.css>
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
				<li><a href=reg.php>Реєстрація</a></li>
				<li><a href=reg.php>Увійти</a></li>
			</ul>			
		</header>
		<div class="reg_content">
			<div class="sign_up">
				<p>Ще не маєте аккаунту?</p>
				<form action=login.php method=POST>
					<p><input type=text name=user required placeholder="Логін*"></p>
					<p><input type=password name=password required placeholder="Пароль*"></p>
					<p><input type=email name=email required placeholder="E-Mail*"></p>
					<p><input type=text name=fname placeholder="Ім'я"></p>
					<p><input type=text name=sname placeholder="Прізвище"></p>
					<p><input type=submit value="Зарееструватися"></p>
				</form>
			</div>
			<div class="sign_in">
				<p>Вже зареєстровані?</p>
				<form action=login.php method=POST>
					<p><input type=text name=user required placeholder="Логін"></p>
					<p><input type=password name=password required placeholder="Пароль"></p>
					<p><input type=checkbox id='rem' name='remember'><label for="rem"><t> Запам'ятати</label></p>
					<p><input type=submit value="Увійти"></p>
				</form>
			</div>
		</div>
		<footer><p>Made by viiper94 &copy; 2015</p></footer>
	</body>
</html>