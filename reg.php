<?php session_start();
$ret_val=$_POST;
if (!isset($ret_val['submit']))
{
echo '<html>
<head>
<title>Регистрация</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
include 'header.php';
echo "<td colspan='4'><table height='50%' width='50%' align='center'><tr><td>
<form name='regform' action='reg.php' method='post'>
<fieldset>
<legend>Обязательная информация</legend> 
<table>
<tr>
<td>Логин: </td><td><input name='login' type='text' value=''></td>
</tr>
<tr>
<td>Электронная почта: </td><td><input name='email' type='text' value=''></td>
</tr>

<script language='javascript' type='text/javascript'>
function checkmail(value)
{
reg = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
if (!value.match(reg)) {alert('Введите свой настоящий e-mail');
document.getElementById('email').value=''; return false; }
}
</script>

<tr>
<td>Пароль: </td><td><input name='password' type='password' value=''></td>
</tr>
<tr>
<td>Повторите пароль: </td><td><input name='password2' type='password' value=''></td>
</tr>
</table>
<br><img src='secpic/secpic.php' alt='защитный код' ><br>
Введите защитный код на картинке: <input name='secpic' type='text' value=''>
</fieldset>
<fieldset>
<legend>Дополнительно</legend> 
Высылать на почту новости сайта: <input name='news' type='checkbox'>
</fieldset>
<br>
<input type='reset' name='reset' value='Сброс данных'> 
<input type='submit' name='submit' value='Зарегистрироваться'>
</form></td></tr>
</table>";
include 'cellar.php';
}
else
{
echo '<html>
<head>
<title>Регистрация</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>';
include_once("connect.php");
if (isset($_POST['submit']))
{
if(empty($_POST['login']))
{
echo '<meta http-equiv="Refresh" content="5; url=reg.php">
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Вы не ввели логин.<br>Перенаправление на страницу регистрации...</p></td></tr>
</table>';
include 'cellar.php';
}
elseif(empty($_POST['password']))
{
echo '<meta http-equiv="Refresh" content="5; url=reg.php">
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Вы не ввели пароль.<br>Перенаправление на страницу регистрации...</p></td></tr>
</table>';
include 'cellar.php';
}
elseif(empty($_POST['password2']))
{
echo '<meta http-equiv="Refresh" content="5; url=reg.php">
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Вы не ввели подтверждение пароля.<br>Перенаправление на страницу регистрации...</p></td></tr>
</table>';
include 'cellar.php';
}
elseif($_POST['password'] != $_POST['password2'])
{
echo '<meta http-equiv="Refresh" content="5; url=reg.php">
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Введённые пароли не совпадают.<br>Перенаправление на страницу регистрации...</p></td></tr>
</table>';
include 'cellar.php';
}
elseif(empty($_POST['secpic']))
{
echo '<meta http-equiv="Refresh" content="5; url=reg.php">
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Вы не ввели защитный код.<br>Перенаправление на страницу регистрации...</p></td></tr>
</table>';
include 'cellar.php';
}
elseif($_SESSION['secpic']!=strtolower($_POST['secpic']))
{
echo '<meta http-equiv="Refresh" content="5; url=reg.php">
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Неправильно введён защитный код.<br>Перенаправление на страницу регистрации...</p></td></tr>
</table>';
include 'cellar.php';
}
else
{
$login = $_POST['login'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$email = $_POST['email'];
$news = $_POST['news']; {if (isset($_POST['news'])) {$news=1;} else {$news=0;}}
$query = "SELECT id FROM users WHERE login='{$login}' AND password='{$password}'";
$sql = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($sql) > 0)
{
echo '<meta http-equiv="Refresh" content="5; url=reg.php">
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Такой логин уже существует.<br>Перенаправление на страницу регистрации...</p></td></tr>
</table>';
include 'cellar.php';
}
else
{
$login=mysql_real_escape_string($login);
$password=mysql_real_escape_string($password);
$email=mysql_real_escape_string($email);
$news=mysql_real_escape_string($news);
$query = "INSERT INTO users (login , password , email, news) VALUES ('$login', '$password', '$email', '$news')";
$result = mysql_query($query) or die(mysql_error());
mkdir("/userfiles/".$_POST['login']);
echo '
<meta http-equiv="Refresh" content="5; url=index.php">
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Регистрация пройдена успешно.<br>Перенаправление на главную страницу...</p></td></tr>
</table>';
include 'cellar.php';
}
}
}
}
?>