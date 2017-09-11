<?php
class BlokiEdit{
	var $id;
	var $dbblok;
	var $blok;
function BlokiEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbblok = new dbblok();
		$this->blok = $this->dbblok->get($this->id);
		

	}
	function Paint(){
		?>
		<a href='?view=BlokiView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=BlokiEdit&action=updateBlokiAction&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->blok['id']);?>"></td></tr>
			<tr><td>blok</td><td><input type="text" name="blok" value="<?php echo(htmlspecialchars($this->blok['blok']));?>"></td></tr>
			<tr><td>sortindex</td><td><input type="text" name="sortindex" value="<?php echo($this->blok['sortindex']);?>"></td></tr>
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