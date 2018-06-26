<?PHP session_start();
include_once("connect.php");
if (isset($_POST['update']))
{
if (!empty($_POST['npw'])) mysql_query("UPDATE users SET password='".$_POST['npw']."' WHERE login='".$_SESSION['username']."'");
if (isset($_POST['news'])) mysql_query("UPDATE users SET news='1' WHERE login='".$_SESSION['username']."'");
else mysql_query("UPDATE users SET news='0' WHERE login='".$_SESSION['username']."'");
echo '<html>
<head>
<title>Профиль</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
<meta http-equiv="Refresh" content="5; url=index.php">
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Изменения внесены.<br>Перенаправление на главную страницу...</p></td></tr>
</table>';
include 'cellar.php';
}
elseif ($_SESSION['authorized']==true)
{
$res=mysql_query("SELECT login, email, news FROM users WHERE login='".$_SESSION['username']."'") or die(mysql_error()); 
$row=mysql_fetch_array($res);
echo '<html>
<head>
<title>Профиль</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
include 'header.php';
echo "<td colspan='4'><table width='100%' height='100%'><tr><td align='center'><form name='upd' action='account.php' method='post'><table>
<tr><td>Логин:</td><td>{$row['login']}</td></tr>
<tr><td>Электронная почта:</td><td>{$row['email']}</td></tr>
<tr><td>Новый пароль:</td><td><input type='password' name='npw' value=''></td></tr>
<tr><td>Рассылка новостей:</td><td>";
if ($row['news']=='0') $news='<input type="checkbox" name="news" value="1">';
else $news='<input type="checkbox" name="news" value="1" checked>';
echo "{$news}</td></tr></table><br>
<input type='submit' name='update' value='Обновить'>
</form></td></tr></table>";
include 'cellar.php';
}
?>