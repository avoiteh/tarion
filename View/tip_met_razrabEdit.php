<?php
class tip_met_razrabEdit{
	var $id;
	var $dbnov_type;
	var $nov_type;
function tip_met_razrabEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbnov_type = new dbnov_type();
		$this->nov_type = $this->dbnov_type->get($this->id);
		

	}
	function Paint(){
		?>
		<a href='?view=tip_met_razrabView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=tip_met_razrabEdit&action=updatetip_met_razrabAction&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->nov_type['id']);?>"></td></tr>
			<tr><td>novtype</td><td><input type="text" name="novtype" value="<?php echo(htmlspecialchars($this->nov_type['novtype']));?>"></td></tr>
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