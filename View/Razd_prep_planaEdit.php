<?php
class Razd_prep_planaEdit{
	var $id;
	var $dbppr;
	var $ppr;
function Razd_prep_planaEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbppr = new dbppr();
		$this->ppr = $this->dbppr->get($this->id);
		

	}
	function Paint(){
		?>
		<a href='?view=Razd_prep_planaView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Razd_prep_planaEdit&action=updateRazd_prep_planaAction&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->ppr['id']);?>"></td></tr>
			<tr><td>razdel</td><td><input type="text" name="razdel" value="<?php echo(htmlspecialchars($this->ppr['razdel']));?>"></td></tr>
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