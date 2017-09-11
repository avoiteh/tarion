<?php
class SpetsialnostiEdit{
	var $id;
	var $dbtop_spec;
	var $top_spec;
function SpetsialnostiEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbtop_spec = new dbtop_spec();
		$this->top_spec = $this->dbtop_spec->get($this->id);
		

	}
	function Paint(){
		?>
		<a href='?view=SpetsialnostiView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=SpetsialnostiEdit&action=updateSpetsialnostiAction&id=<?=$this->id?>">

			<tr><td>topspec</td><td><input type="text" name="topspec" value="<?php echo(htmlspecialchars($this->top_spec['topspec']));?>"></td></tr>
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