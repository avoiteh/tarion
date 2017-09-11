<?php
class Bibliotechnye_kategoriiEdit{
	var $id;
	var $dblibcat;
	var $libcat;
function Bibliotechnye_kategoriiEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dblibcat = new dblibcat();
		$this->libcat = $this->dblibcat->get($this->id);
		

	}
	function Paint(){
		?>
		<a href='?view=Bibliotechnye_kategoriiView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Bibliotechnye_kategoriiEdit&action=updateBibliotechnye_kategoriiAction&id=<?=$this->id?>">

			<tr><td>libcat</td><td><input type="text" name="libcat" value="<?php echo(htmlspecialchars($this->libcat['libcat']));?>"></td></tr>
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