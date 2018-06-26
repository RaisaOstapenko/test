<?PHP session_start();
include_once("connect.php");
include 'func.php';
if ($_SESSION['adm']==1)
{
echo '<html>
<head>
<title>Администрирование</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
include 'header.php';

if (!$_SERVER['QUERY_STRING'])
{
echo '<td colspan="2"><table width="100%"><tr><td align="center" colspan="4" height="10"><h2>Пользователи</h2></td></tr>
<tr><td><p>ID</p></td><td><p>Имя пользователя</p></td><td><p>Объём данных (KB)</p></td><td><p>Администратор</p></td></tr>';
$res=mysql_query("SELECT login, id, adm FROM users ORDER BY id ASC");
while($row=mysql_fetch_array($res))
{
$kb=getFilesSize("userfiles/".$row['login'])/1024;
echo "<tr><td>{$row['id']}</td><td>{$row['login']}</td><td>{$kb}</td>
<td><form name='admupd' action='admin.php' method='post'>
<input type='hidden' name='username' value='{$row['login']}'>";
if ($row['adm']=='0') $adm='<input type="checkbox" name="adm" value="1">';
else $adm='<input type="checkbox" name="adm" value="1" checked>';
echo "{$adm} <input type='submit' name='admupd' value='Обновить'>
</form></td></tr>";
}
echo '</table></td>
<td colspan="2"><table width="100%"><tr><td align="center" colspan="3" height="10"><h2>Сообщения</h2></td></tr>
<tr><td><p>Имя пользователя</p></td><td><p>Тема сообщения</p></td><td><p>Действия</p></td></tr>';
$res=mysql_query("SELECT * FROM messages ORDER BY messageid DESC");
while($row=mysql_fetch_array($res))
{
echo "<tr><td>{$row['username']}</td><td>{$row['theme']}</td><td><a href='admin.php?id={$row['messageid']}'>Прочитать</a></td></tr>";
}
echo '</table>';
}

if ($_GET['id'])
{
$messageid=mysql_real_escape_string($_GET['id']);
$ress=mysql_query("SELECT * FROM messages WHERE messageid ='{$messageid}' LIMIT 1") or die(mysql_error());
$row=mysql_fetch_array($ress);
echo "<td colspan='4'><table height='100%' width='100%'><tr><td>
<form name='rpl' action='letter.php' method='post'><p>
Тема сообщения: <input type='text' name='thm' value='{$row['theme']}' readonly>
<input type='hidden' name='theme' value='Re: {$row['theme']}'>
<input type='hidden' name='messageid' value='{$_GET['id']}'>
<input type='hidden' name='remail' value='{$row['email']}'><br>
Сообщение:<br>
<textarea name='msg' id='msg' cols='45' rows='5' readonly>{$row['text']}</textarea><br>
Введите ответ:</p>
<textarea name='rpl' id='rpl' cols='45' rows='5'></textarea><br>
<input type='submit' name='delete' value='Удалить'><input type='submit' name='reply' value='Ответить'>
</form></td></tr>
</table>";
}

if (isset($_POST['admupd']))
{
if (isset($_POST['adm'])) mysql_query("UPDATE users SET adm='1' WHERE login='".$_POST['username']."'");
else mysql_query("UPDATE users SET adm='0' WHERE login='".$_POST['username']."'");
echo '<html>
<head>
<title>Профиль</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
<meta http-equiv="Refresh" content="5; url=admin.php">
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Изменения внесены.<br>Перенаправление на страницу администрирования...</p></td></tr>
</table>';
include 'cellar.php';
}
}

else
{
echo '<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<meta http-equiv="Refresh" content="5; url=index.php">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
include 'header.php';
echo '<td colspan="4" align="center"><table height="50%" width="50%"><tr>
<td><p align="center">Доступ запрещён.<br>Перенаправление на главную страницу...</p></td></tr></table>';
}
include 'cellar.php';
?>