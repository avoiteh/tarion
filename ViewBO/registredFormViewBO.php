<?php
class registredFormViewBO{
	function registredFormViewBO(){}
	function Paint(){
?>
�� ���������������� � ������������ �������. ���������� � ��������������.
<table border="1">
<tr>
	<td>login</td>
	<td><?php echo $_SESSION['registr']['login'];?></td>
</tr>
<tr>
	<td>email</td>
	<td><?php echo $_SESSION['registr']['email'];?></td>
</tr>

</table>
<?php
	}
}
?>