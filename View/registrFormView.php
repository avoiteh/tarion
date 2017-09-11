<?php
class registrFormView{
	function registrFormView(){}
	function Paint(){
?>
<form method="POST" action="?view=registredFormView&action=registrFormAction">
<table border="1">
<tr>
	<td>login</td>
	<td><input type="text" name="login" value="<?php echo $_SESSION['registr']['login'];?>"></td>
</tr>
<tr>
	<td>password</td>
	<td><input type="password" name="password"></td>
</tr>
<tr>
	<td>Подтвердите пароль</td>
	<td><input type="password" name="password2"><?php
	if($_SESSION['registr']['error']=='password error'){?><br>
Вы ввели разные пароли.
	<?php
	}
	?></td>
</tr><tr>
	<td>email</td>
	<td><input type='text' name='email' value='<?php echo $_SESSION['registr']['email'];?>'></td>
</tr>
<tr>
	<td><img src='capche.php?dt=<?php echo date('H:i:s');?>'></td>
	<td><input type="text" name="capche"><?php if($_SESSION['registr']['error']=='capche error'){?>Вы неверно ввели контрольный код.<?php
	}?></td>
</tr>
<tr>
	<td colspan=2><input type="submit" value="Зарегистрироваться"></td>
</tr></table>
</form>
<?php
	}
}
?>