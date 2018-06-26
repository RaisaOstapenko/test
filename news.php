<?PHP session_start();

if (($_SESSION['adm']==1)&&($_SERVER['QUERY_STRING']=='add'))
{
echo '<html>
<head>
<title>Добавление новости</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>';
include 'header.php';
echo '<td colspan=4>
<table id="newstext" cellpadding=10 width="100%" height="100%">
<tr>
<td><p>
<h2><a href="index.php?ref">Справка</a></h2>
</p></td>
</tr>
<tr>
<td>
<form id="newsform" name="newsform" method="post" action="news.php">
Заголовок новости: <input type="text" name="newsname" value="" size="40"><br>
<textarea name="newseditor" id="newseditor" cols="45" rows="5"></textarea>
<script type="text/javascript">
CKEDITOR.replace("newseditor");
</script>
</form></td></tr></table>';
include 'cellar.php';
die();
}

if (($_SESSION['adm']==1)&&(isset($_POST['newseditor'])))
{
include_once("connect.php");

$newsname=mysql_real_escape_string($_POST['newsname']);

$query="INSERT INTO news(newsname , newsdate) VALUES ('$newsname', NOW())";
$result=mysql_query($query) or die(mysql_error());
$newsid=mysql_query("SELECT newsid FROM news WHERE newsname ='{$newsname}' LIMIT 1");
while($row=mysql_fetch_array($newsid))
{
$f=fopen("news/".$row['newsid'].".html","a+");
}
fwrite($f,$_POST['newseditor']);
fclose($f);

$ff='news';
include 'letter.php';

echo '<html>
<head>
<title>Сохранение файла</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
<meta http-equiv="Refresh" content="5; url=index.php">
</head>';
//Вывод шапки
include 'header.php';
echo '<td colspan="4"><table align="center" width="50%" height="50%"><tr><td>
<p>Новость успешно добавлена.<br>Перенаправление на главную страницу...</p>
</td></tr></table>';
include 'cellar.php';
}

if ($_SERVER['QUERY_STRING']=='arch')
{
echo '<html>
<head>
<title>Архив новостей</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
//Вывод шапки
include 'header.php';
echo '<td colspan="4"><table cellpadding=10 width="100%" height="100%"><tr><td>
<p><h2>Архив новостей&nbsp;<a href="index.php?ref">Справка</a></h2>';

include_once("connect.php");
$res=mysql_query("SELECT * FROM news ORDER BY newsdate DESC");
echo "<tr><td><p>";
while($row=mysql_fetch_array($res))
{
echo "<h3><a name='{$row['newsid']}'></a>{$row['newsname']}</h3><br>
{$row['newsdate']}<br>";
include "news/".$row['newsid'].".html";
echo "<br>";
}

echo '</p>
</td></tr></table>';
include 'cellar.php';
}

else
{
if ($_SESSION['adm']==1)
{
echo '<td><a href="news.php?add"><input type="button" name="add" value="Добавить новость"></a></td></tr>';
}
include_once("connect.php");
$res=mysql_query("SELECT * FROM news ORDER BY newsdate DESC LIMIT 10");
echo "<tr><td><p>";
while($row=mysql_fetch_array($res))
{
echo "<hr><h3><a name='{$row['newsid']}'></a>{$row['newsname']}</h3><br>
{$row['newsdate']}<br>";
include "news/".$row['newsid'].".html";
echo "<br>";
}
echo "<br><a href='news.php?arch'><input type='button' name='archive' value='Архив новостей'></a></p></td></tr>";
}
?>