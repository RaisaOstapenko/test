echo "<td colspan='4'><table height='50%' width='50%' align='center'><tr><td>
<form name='regform' action='reg.php' method='post'>
<fieldset>
<legend>Обязательная информация</legend> 
<table>
<tr>
<td>Логин: </td><td><input name='login' type='text' value=''></td>
</tr>
<tr>
<td>Электронная почта: </td><td><input name='email' type='text' value=''></td>
</tr>

<script language='javascript' type='text/javascript'>
function checkmail(value)
{
reg = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
if (!value.match(reg)) {alert('Введите свой настоящий e-mail');
document.getElementById('email').value=''; return false; }
}
</script>

<tr>
<td>Пароль: </td><td><input name='password' type='password' value=''></td>
</tr>
<tr>
<td>Повторите пароль: </td><td><input name='password2' type='password' value=''></td>
</tr>
</table>
<br><img src='secpic/secpic.php' alt='защитный код' ><br>
Введите защитный код на картинке: <input name='secpic' type='text' value=''>
</fieldset>
<fieldset>
<legend>Дополнительно</legend> 
Высылать на почту новости сайта: <input name='news' type='checkbox'>
</fieldset>
<br>
<input type='reset' name='reset' value='Сброс данных'> 
<input type='submit' name='submit' value='Зарегистрироваться'>
</form></td></tr>
</table>";