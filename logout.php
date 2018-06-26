<?PHP session_start();
if($_SESSION['adm']) unset($_SESSION['adm']);
unset($_SESSION['username']);
unset($_SESSION['authorized']);
session_destroy();
echo '<html>
<head>
<title>Выход</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
<meta http-equiv="Refresh" content="5; url=index.php">
</head>';
include 'header.php';
echo '<td colspan="4"><table height="50%" width="50%" align="center"><tr><td>
<p>Вы вышли.<br>Перенаправление на главную страницу...</p></td></tr>
</table>';
include 'cellar.php';
?>