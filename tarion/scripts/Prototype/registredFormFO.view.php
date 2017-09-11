<?php
function makeRegistredFormFO($tables){
	$s="<?php
class registredFormView{
	function registredFormView(){}
	function Paint(){
?>
Вы зарегистрированы с минимальными правами. Обратитесь к администратору.
<table border=\"1\">
<tr>
	<td>login</td>
	<td><?php echo \$_SESSION['registr']['login'];?></td>
</tr>
";
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){
		$s.="<tr>
	<td>$fname</td>
	<td><?php echo \$_SESSION['registr']['$fname'];?></td>
</tr>
";
		}
	}
$s.="
</table>
<?php
	}
}
?>";
	return $s;
}
?>