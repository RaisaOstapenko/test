<?php session_start();
//Вывод заголовка
echo '<html>
<head>
<title>WEB pad - онлайн-блокнот</title>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<link rel="stylesheet" type="text/css" href="skin/fxfxf.css"/>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>';
//Открытие тела страницы, вывод шапки
include 'header.php';
//Открытие текста редактора (при входе на сайт, при переходе к редактору из новостей, справки, списка файлов пользователя), либо справки, либо новостей
include 'mode.php';
//Закрытие текста редактора, новости или справки, открытие текста списка новостей
echo '</table>
</td>
<td width="26%">
<table id="news" cellpadding=10 width="100%" height="100%">';
//Вывод списка последних новостей
include 'lastnews.php';
echo '</table>';
include 'cellar.php';
?>
