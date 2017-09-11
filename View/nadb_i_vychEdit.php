<?php
class nadb_i_vychEdit{
	var $id;
	var $dbnadbvych;
	var $nadbvych;
function nadb_i_vychEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbnadbvych = new dbnadbvych();
		$this->nadbvych = $this->dbnadbvych->get($this->id);
		

	}
	function Paint(){
		?>
		<a href='?view=nadb_i_vychView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=nadb_i_vychEdit&action=updatenadb_i_vychAction&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->nadbvych['id']);?>"></td></tr>
			<tr><td>naim</td><td><input type="text" name="naim" value="<?php echo(htmlspecialchars($this->nadbvych['naim']));?>"></td></tr>
			<tr><td>formula</td><td><input type="text" name="formula" value="<?php echo(htmlspecialchars($this->nadbvych['formula']));?>"></td></tr>
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