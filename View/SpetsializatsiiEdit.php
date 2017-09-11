<?php
class SpetsializatsiiEdit{
	var $id;
	var $dbspecial;
	var $special;
var $dbtop_spec;
var $listtop_spec;
function SpetsializatsiiEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbspecial = new dbspecial();
		$this->special = $this->dbspecial->get($this->id);
		
$this->dbtop_spec = new dbtop_spec();
//получаем лист для lookUp
		$this->listtop_spec=$this->dbtop_spec->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=SpetsializatsiiView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=SpetsializatsiiEdit&action=updateSpetsializatsiiAction&id=<?=$this->id?>">

			<tr><td>special</td><td><input type="text" name="special" value="<?php echo(htmlspecialchars($this->special['special']));?>"></td></tr>
			<tr><td>topspec</td><td><?php echo($this->lookUp($this->listtop_spec, $this->special['topspec'], 'topspec', 'topspec'));?></td></tr>
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