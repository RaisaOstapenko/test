<?PHP session_start();
include_once("connect.php");

if ($_GET['delete'])
{
$res=mysql_query("SELECT * FROM userfiles WHERE username='".$_SESSION['username']."' AND fileid='".$_GET['delete']."' ");
$row=mysql_fetch_array($res);
unlink("userfiles/".$row['username']."/".$row['fileid'].$row['extension']);
mysql_query("DELETE FROM userfiles WHERE username='".$_SESSION['username']."' AND fileid='".$_GET['delete']."' ");
echo '<html>
<head>
<title>Файлы</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<meta http-equiv="Refresh" content="5; url=files.php">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
include 'header.php';
echo '<td colspan="4" align="center"><table height="50%" width="50%"><tr>
<td><p align="center">Файл удалён.<br>Перенаправление на страницу файлов...</p></td></tr></table>';
include 'cellar.php';
die();
}

if ($_SESSION['authorized']==true)
{
$res=mysql_query("SELECT * FROM userfiles WHERE username='".$_SESSION['username']."' ORDER BY fileid DESC");
echo '<html>
<head>
<title>Файлы</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
</head>';
include 'header.php';
echo "<td colspan='4'><table width='100%'>
<tr><td align='center' colspan='3' height='10'><h2>Файлы</h2></td></tr>
<tr><td><p>ID</p></td><td><p>Имя файла</p></td><td><p>Размер (KB)</p></td><td><p>Действия</p></td></tr>";
while($row=mysql_fetch_array($res))
{
$kb=filesize("userfiles/".$row['username']."/".$row['fileid'].$row['extension'])/1024;
echo "<tr><td>{$row['fileid']}</td><td>{$row['filename']}</td><td>{$kb}</td>
<td><a href='userfiles/{$row['username']}/{$row['fileid']}{$row['extension']}'>Загрузить</a><br>
<a href='index.php?fileid={$row['fileid']}'>Редактировать</a><br>
<a href='files.php?delete={$row['fileid']}'>Удалить</a></td></tr>";
}
echo "</table>";
include 'cellar.php';
}
?>