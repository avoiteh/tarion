<?php
class Prava_BOEditBO{
	var $id;
	var $dbright;
	var $right;
function Prava_BOEditBO(){
		$this->id=$_REQUEST['id']*1;
		$this->dbright = new dbright();
		$this->right = $this->dbright->get($this->id);
		

	}
	function Paint(){
		?>
		<a href='?view=Prava_BOViewBO'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Prava_BOEditBO&action=updatePrava_BOActionBO&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->right['id']);?>"></td></tr>
			<tr><td>name</td><td><input type="text" name="name" value="<?php echo(htmlspecialchars($this->right['name']));?>"></td></tr>
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