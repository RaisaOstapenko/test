<?php
$dblocation = "localhost";
$dbname = "webpdb";
$dbuser = "root";
$dbcnx = @mysql_connect($dblocation, $dbuser);
if (!$dbcnx)
{
echo( "<P> В настоящий момент сервер базы данных не доступен, поэтому корректное отображение страницы невозможно. </P>" );
exit();
}
mysql_select_db($dbname) or die(mysql_error());
if (!@mysql_select_db($dbname, $dbcnx))
{
echo( "<P> В настоящий момент база данных не доступна, поэтому корректное отображение страницы невозможно. .</P>" );
exit();
}
?>