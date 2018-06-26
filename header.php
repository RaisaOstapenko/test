<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	</head>
<?PHP session_start();
echo '<body>
<table id="tb" align="center" width="904" height="100%" cellpadding=10 cellspacing=0 border=0>
<tr>
<td background="skin/h-l.gif" width="50%" height="155" align="center" colspan=2>
<a href="index.php"><h1>WEB pad</h1></a>
</td>
<td background="skin/h-r.gif" width="50%" height="155" align="right" colspan=2>
<table width="50%" height="100" id="userview">
<tr>
<td align="right">';

//________Отображение формы входа пользователя (для гостя) или элементов управления (для вошедшего пользователя или администратора)
if (($_SESSION['authorized']==true)&&($_SESSION['adm']==1))  
echo '<a href="admin.php">Администрирование</a><br>
<a href="account.php">Профиль</a><br>
<a href="files.php">Файлы</a><br>
<a href="logout.php">Выход</a>';

elseif ($_SESSION['authorized']==true)
echo '<a href="account.php">Профиль</a><br>
<a href="files.php">Файлы</a><br>
<a href="logout.php">Выход</a>';

else
echo '<form name="logform" action="avt.php" method="post"><input type="text" name="login" value="Логин" size=24><br>
<input type="password" name="password" value="Пароль" size=24><br>
<input type="submit" name="auth" value="Вход"><a href="reg.php"><input type="button" name="reg" value="Регистрация"></a></form>';

echo '</td>
</tr>
</table>
</td>
</tr>
<tr>';

?>