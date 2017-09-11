<?php
class Moduli_FO_derevo_EditBO{
	var $id;
	var $dbfront_modules;
	var $front_modules;
function Moduli_FO_derevo_EditBO(){
		$this->id=$_REQUEST['id']*1;
		$this->dbfront_modules = new dbfront_modules();
		$this->front_modules = $this->dbfront_modules->get($this->id);
		

	}
	function Paint(){
		?>
		<a href='?view=Moduli_FO_derevo_ViewBO'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Moduli_FO_derevo_EditBO&action=updateModuli_FO_derevo_ActionBO&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->front_modules['id']);?>"></td></tr>
			<tr><td>module</td><td><input type="text" name="module" value="<?php echo(htmlspecialchars($this->front_modules['module']));?>"></td></tr>
			<tr><td>parent</td><td><input type="text" name="parent" value="<?php echo($this->front_modules['parent']);?>"></td></tr>
			<tr><td>title</td><td><input type="text" name="title" value="<?php echo(htmlspecialchars($this->front_modules['title']));?>"></td></tr>
			<tr><td>type</td><td><input type="text" name="type" value="<?php echo(htmlspecialchars($this->front_modules['type']));?>"></td></tr>
		<tr><td colspan="2"><input value=" O.K. " type="submit"></td></tr>
		</form>
		</table>
		<?php
	}
	function lookUp(&$list, $id, $field_name, $name){
		$s="<select name='$name'>
		<option value=0> --- </option>
";
		$fna=explode(':',$field_name);
		if(is_array($list)){
			foreach ($list as $rec){
				$s.="<option value='$rec[id]'";
				if($rec['id']==$id){
					$s.=" selected";
				}
				$s.='>';
				foreach ($fna as $ofn){
					$s.=$rec[$ofn].' ';
				}
				$s.="</option>
";
			}
		}
		$s.="</select>
";
		return $s;
	}
	function photo($photo, $name){
		$path=photoPath($photo).'/'.$name;
		if(file_exists($path)){
			return "<img src='$path'>";
		}else{
			return "<img src='./photo/noimage.png'>";
		}
	}
}
?>