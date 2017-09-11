<?php
function makeRegistrFormBO($tables){
	$s="<?php
class registrFormViewBO{
	function registrFormViewBO(){}
	function Paint(){
?>
<form method=\"POST\" action=\"?view=registredFormViewBO&action=registrFormActionBO\">
<table border=\"1\">
<tr>
	<td>login</td>
	<td><input type=\"text\" name=\"login\" value=\"<?php echo \$_SESSION['registr']['login'];?>\"></td>
</tr>
<tr>
	<td>password</td>
	<td><input type=\"password\" name=\"password\"></td>
</tr>
<tr>
	<td>Подтвердите пароль</td>
	<td><input type=\"password\" name=\"password2\"><?php
	if(\$_SESSION['registr']['error']=='password error'){?><br>
Вы ввели разные пароли.
	<?php
	}
	?></td>
</tr>";
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){
		$s.="<tr>
	<td>$fname</td>
	<td><input type='text' name='$fname' value='<?php echo \$_SESSION['registr']['$fname'];?>'></td>
</tr>
";
		}
	}
$s.="<tr>
	<td><img src='capche.php?dt=<?php echo date('H:i:s');?>'></td>
	<td><input type=\"text\" name=\"capche\"><?php if(\$_SESSION['registr']['error']=='capche error'){?>Вы неверно ввели контрольный код.<?php
	}?></td>
</tr>
<tr>
	<td colspan=2><input type=\"submit\" value=\"Зарегистрироваться\"></td>
</tr></table>
</form>
<?php
	}
}
?>";
	return $s;
}
?>