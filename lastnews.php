<?PHP session_start();
include_once("connect.php");
$res=mysql_query("SELECT * FROM news ORDER BY newsdate DESC LIMIT 3");
echo "<tr><td height='10'>
<a href='index.php?news'><h2>Последние новости</h2></a></td></tr><tr><td height='100'>";
while($row=mysql_fetch_array($res))
{
echo "<hr><h3><a href='index.php?news#{$row['newsid']}'>{$row['newsname']}</a></h3>
{$row['newsdate']}<br>";
}
echo "</td><tr>";
?>