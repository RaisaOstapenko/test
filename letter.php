<?PHP session_start();
include_once("connect.php");

if ($ff=='file')
{
$subject = "WEB pad: сохранённый файл";
$message = "<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset='utf-8'>
<title>Ваш сохранённый файл</title>
</head>
<body>
<p>
Ссылка: <a href='http://"."{$_SERVER['SERVER_NAME']}/userfiles/unregistered/{$fileid}.html'>
http://"."{$_SERVER['SERVER_NAME']}/userfiles/unregistered/{$fileid}.html</a><br>
Ссылка на файл действительна на протяжении недели, по истечении которой файл будет удалён с сервера
</p>
</body>
</html>";
$to = $_POST['email'];
mail($to, $subject, $message); 
}

if ($ff=='news')
{
$subject = "WEB pad: рассылка новостей";
$message = "<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset='utf-8'>
<title>{$_POST['newsname']}</title>
</head>
<body>
<p>
{$_POST['newseditor']}
</p>
</body>
</html>";
$res=mysql_query("SELECT email FROM users WHERE news !=0");
while($to=mysql_fetch_array($res))
{
mail($to, $subject, $message); 
}
}

if (isset($_POST['reply']))
{
echo '<html>
<head>
<title>Обратная связь</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<meta http-equiv="Refresh" content="5; url=admin.php">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>';
if (empty($_POST['rpl'])) {echo '<p>Поле ответа пусто.<br>Перенаправление на страницу администрирования...</p>';}
else
{
$subject = "WEB pad: ответ на сообщение";
$message = "<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset='utf-8'>
<title>{$_POST['theme']}</title>
</head>
<body>
<p>
{$_POST['rpl']}
</p>
</body>
</html>";
$to=$_POST['remail'];
mail($to, $subject, $message);
echo '<p>Ваш ответ отправлен.<br>Перенаправление на страницу администрирования...</p>';
}
echo '</td></tr></table>';
include 'cellar.php';
die();
}

if (isset($_POST['delete']))
{
mysql_query("DELETE FROM messages WHERE messageid='{$_POST['messageid']}'");
echo '<html>
<head>
<title>Обратная связь</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<meta http-equiv="Refresh" content="5; url=admin.php">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Сообщение удалено.<br>Перенаправление на страницу администрирования...</td></tr></table>';
include 'cellar.php';
die();
}

if (isset($_POST['sbm']))
{
echo '<html>
<head>
<title>Обратная связь</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<meta http-equiv="Refresh" content="5; url=index.php">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>';
if (empty($_POST['msg']))
{
echo '<p>Вы не ввели текст сообщения.<br>Перенаправление на главную страницу...</p>';
}
else
{
$subject = "WEB pad: сообщение";
$message = "<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset='utf-8'>
<title>{$_POST['theme']}</title>
</head>
<body>
<p>
{$_POST['msg']}
</p>
</body>
</html>";

$to=mysql_query("SELECT email FROM users WHERE adm='1'");
$trow=mysql_fetch_array($to);
mail($trow['email'], $subject, $message);
if ($_SESSION['authorized']==true)
{
$email=mysql_query("SELECT email FROM users WHERE login='".$_SESSION['username']."' LIMIT 1");
$erow=mysql_fetch_array($email);
mysql_query("INSERT INTO messages(username, text, email, theme) VALUES ('".$_SESSION['username']."', '".$_POST['msg']."', '".$erow['email']."', '".$_POST['theme']."')");
}
else mysql_query("INSERT INTO messages(username, text, email, theme) VALUES ('гость', '".$_POST['msg']."', '".$_POST['email']."', '".$_POST['theme']."')");
echo '<p>Ваше сообщение отправлено.<br>Перенаправление на главную страницу...</p>';
}
echo '</td></tr></table>';
include 'cellar.php';
die();
}

if (!$ff)
{
echo '<html>
<head>
<title>Обратная связь</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
include 'header.php';
echo '<td colspan="4"><table height="100%" width="100%"><tr><td>
<form name="fdb" action="letter.php" method="post"><p>
Введите тему вопроса или предложения: <input type="text" name="theme" value=""><br>';
if (!$_SESSION['authorized'])
echo "Введите email: <input type='text' name='theme' value=''><br>
<script language='javascript' type='text/javascript'>
function checkmail(value)
{
reg = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
if (!value.match(reg)) {alert('Пожалуйста, введите свой настоящий e-mail');
document.getElementById('email').value=''; return false; }
}
</script>";
echo 'Введите свой вопрос или предложение:<br>
<textarea name="msg" id="msg" cols="45" rows="5"></textarea><br>
<input type="submit" name="sbm" value="Отправить">
</p></form>
</td></tr></table>';
include 'cellar.php';
}

?>