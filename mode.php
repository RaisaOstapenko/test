<?PHP session_start();
echo '<td colspan=3 width="74%">
<table id="text" cellpadding=10 width="100%" height="100%">';

if ($_SERVER['QUERY_STRING']=='ref') //Вывод справки
include 'ref.html';

elseif ($_SERVER['QUERY_STRING']=='news') //Вывод новостей
include 'news.php';

elseif (($_SESSION['authorized']==true)&&($_GET['fileid'])) //Вариант текстового редактора при открытии сохранённого на сервере файла
{
include_once("connect.php");
$username=mysql_real_escape_string($_SESSION['username']);
$rst=mysql_query("SELECT fileid FROM userfiles WHERE username ='{$username}'");
$fff=0;
while($row=mysql_fetch_array($rst))
{
if ($_GET['fileid']==$row['fileid']) {$fff=1; break;}
}
if ($fff==1)
{
$fileid=$_GET['fileid'];
$ress=mysql_query("SELECT extension, filename FROM userfiles WHERE fileid ='{$fileid}' LIMIT 1");
$row=mysql_fetch_array($ress);
$filetext=fopen("userfiles/".$_SESSION['username']."/".$fileid.$row['extension'], "r");
echo "<tr>
<td>
<a href='index.php?ref'><h2>Справка</h2></a>
<form id='form1' name='form1' method='post' action='load.php'>
<textarea name='editor1' id='editor1' cols='45' rows='5'>{$filetext}</textarea>
<script type='text/javascript'>
CKEDITOR.replace('editor1');
</script>
<input type='hidden' name='filename' value='{$row['filename']}'>
<input type='hidden' name='extension' value='{$row['extension']}'>
</form>
</td></tr>";
fclose($filetext);
}
else echo '<p align="center">Ошибка.<br>Вы пытались открыть файл, принадлежащий другому пользователю</p>';
}

else  //Вариант текстового редактора по умолчанию
echo '<tr>
<td>
<a href="index.php?ref"><h2>Справка</h2></a>
<form id="form1" name="form1" method="post" action="load.php">
<textarea name="editor1" id="editor1" cols="45" rows="5"></textarea>
<script type="text/javascript">
CKEDITOR.replace("editor1");
</script>
</form>
</td></tr>';

?>