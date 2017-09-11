<?php
class KabinetyEdit{
	var $id;
	var $dbkabinet;
	var $kabinet;
function KabinetyEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbkabinet = new dbkabinet();
		$this->kabinet = $this->dbkabinet->get($this->id);
		

	}
	function Paint(){
		?>
		<a href='?view=KabinetyView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=KabinetyEdit&action=updateKabinetyAction&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->kabinet['id']);?>"></td></tr>
			<tr><td>kabinet</td><td><input type="text" name="kabinet" value="<?php echo(htmlspecialchars($this->kabinet['kabinet']));?>"></td></tr>
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