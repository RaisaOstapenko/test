<?php session_start();
include_once("connect.php");
if(isset($_POST['auth']))
{
$login = $_POST['login'];
$password = $_POST['password'];
$login=mysql_real_escape_string($login);
$password=mysql_real_escape_string($password);
$query = "SELECT id, login, password FROM users WHERE login ='{$login}' AND password='{$password}' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
echo '<html>
<head>
<title>Вход</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<meta http-equiv="Refresh" content="5; url=index.php">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>';
if (mysql_num_rows($sql) == 1)
{
echo '<p>Авторизация прошла успешно.<br>Перенаправление на главную страницу...</p>';
$_SESSION['authorized']=true;
$_SESSION['username']=$_POST['login'];
$result=mysql_query("SELECT adm FROM users WHERE login ='{$login}' AND password='{$password}' LIMIT 1");
while($row=mysql_fetch_array($result))
{
if ($row['adm']==1) $_SESSION['adm']=1;
}
}
else echo '<p>Неправильное имя или пароль.<br>Перенаправление на главную страницу...</p>';
echo '</td></tr></table>';
include 'cellar.php';
}
?>