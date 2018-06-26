<?php session_start();

if (!isset($_POST['save'])) //Вывод формы для сохранения файла
{
//Вывод заголовка
echo '<html>
<head>
<title>Сохранение файла</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
//Вывод шапки
include 'header.php';

if ($_SESSION['authorized']) //Форма сохранения для авторизированного пользователя
{
//Перенос значений полей формы в поля сессии
$_SESSION['text']=$_POST['editor1'];
echo "<td colspan='4'><table height='50%' width='50%' align='center'><tr><td>
<form name='saveset' action='load.php' method='post'>
<p>Введите имя файла: <input type='text' name='filename' value='{$_POST['filename']}'><br>
Выберите расширение файла:
<select size='1' name='extension'>
<option value='.html'>HTML</option>
<option value='.txt'>TXT</option>
</select><br></p>
<input type='submit' name='save' value='Сохранить'>
</form></td></tr>
</table>";
}
else //Форма сохранения для гостя
{
//Перенос значений полей формы в поля сессии
$_SESSION['text']=$_POST['editor1'];
echo "<td colspan='4'><table height='50%' width='50%' align='center'><tr><td>
<form name='saveset' action='load.php' method='post'>

<script language='javascript' type='text/javascript'>
function checkmail(value)
{
reg = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
if (!value.match(reg)) {alert('Пожалуйста, введите свой настоящий e-mail');
document.getElementById('email').value=''; return false; }
}
</script>

<p>Введите свой eMail: <input type='text' name='email' value=''><br>
На введённый eMail будет выслана ссылка для загрузки файла<br>
<img src='secpic/secpic.php' alt='защитный код' ><br>
Введите защитный код на картинке: <input name='secpic' type='text' value=''><br>
Ваш файл будет храниться на сервере неделю
</p>
<input type='submit' name='save' value='Сохранить'>
</form></td></tr>
</table>";
}
include 'cellar.php';
}

else
{
include_once("connect.php");

//Вывод заголовка
echo '<html>
<head>
<title>Сохранение файла</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>';

if (($_SESSION['authorized'])&&($_POST['filename']))  //При сохранении файла авторизированным пользователем
{
$query = "INSERT INTO userfiles(username , extension, filename) VALUES ('".$_SESSION['username']."', '".$_POST['extension']."', '".$_POST['filename']."')";
$result = mysql_query($query) or die(mysql_error());
$fileid=mysql_query("SELECT fileid FROM userfiles WHERE username ='".$_SESSION['username']."' LIMIT 1");
while($row=mysql_fetch_array($fileid)){
$f=fopen("userfiles/".$_SESSION['username']."/".$row['fileid'].$_POST['extension'],"w");
}
if ($_POST['extension']=='.html')
{
fwrite($f,'<html><head><meta charset="utf-8"></head><body>');
}
else
{
$search = array ("'<script[^>]*?>.*?</script>'si",
"'<[\/\!]*?[^<>]*?>'si",
"'([\r\n])[\s]+'",
"'&(quot|#34);'i",
"'&(amp|#38);'i",
"'&(lt|#60);'i",
"'&(gt|#62);'i",
"'&(nbsp|#160);'i",
"'&(iexcl|#161);'i",
"'&(cent|#162);'i",
"'&(pound|#163);'i",
"'&(copy|#169);'i",
"'&#(\d+);'e");
$replace = array ("",
"",
"\\1",
"\"",
"&",
"<",
">",
" ",
chr(161),
chr(162),
chr(163),
chr(169),
"chr(\\1)");
$_SESSION['text'] = preg_replace($search, $replace, $_SESSION['text']);
}
fwrite($f,$_SESSION['text']);
if ($_POST['extension']=='.html') fwrite($f,'</body></html>');
fclose($f);
unset($_SESSION['text']);
unset($_SESSION['filename']);
unset($_SESSION['extension']);
echo '<meta http-equiv="Refresh" content="5; url=files.php">
</head>';
//Вывод шапки
include 'header.php';
echo '<td colspan="4"><table align="center" width="50%" height="50%"><tr><td>
<p>Файл успешно сохранён.<br>Перенаправление на страницу файлов...</p>
</td></tr></table>';
}

else //При сохранении файла гостем
{

if ((!$_SESSION['authorized'])&&($_SESSION['secpic']!=strtolower($_POST['secpic']))||(empty($_POST['secpic'])))
{
echo '<meta http-equiv="Refresh" content="5; url=load.php">
</head>';
//Вывод шапки
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Неправильно введён защитный код.<br>Перенаправление на страницу сохранения...</p></td></tr>
</table>';
unset($_POST);
}
else
{
$time_end=time()+(7 * 24 * 60 * 60);
$query = "INSERT INTO userfiles(username , extension, time_end) VALUES ('unregistered' , '.html', '$time_end')";
$result = mysql_query($query) or die(mysql_error());
$fileid=mysql_query("SELECT fileid FROM userfiles WHERE username ='unregistered' LIMIT 1");
$f=fopen("userfiles/unregistered/".$fileid.".html","w");
fwrite($f,'<html><head><meta charset="utf-8"></head><body>');
fwrite($f,$_SESSION['text']);
fwrite($f,'</body></html>');
fclose($f); echo "sdiffjei";
$ff='file';
include 'letter.php';
unset($_SESSION['text']);
echo '<meta http-equiv="Refresh" content="5; url=index.php">
</head>';
//Вывод шапки
include 'header.php';
echo '<td colspan="4"><table width="50%" height="50%"><tr><td>
<p align="center">Файл успешно сохранён.<br>Перенаправление на главную страницу...</p>
</td></tr></table>';
}
}

include 'cellar.php';
}
?>