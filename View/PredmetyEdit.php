<?php
class PredmetyEdit{
	var $id;
	var $dbpredmet;
	var $predmet;
var $dbblok;
var $listblok;
function PredmetyEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbpredmet = new dbpredmet();
		$this->predmet = $this->dbpredmet->get($this->id);
		
$this->dbblok = new dbblok();
//получаем лист для lookUp
		$this->listblok=$this->dbblok->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=PredmetyView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=PredmetyEdit&action=updatePredmetyAction&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->predmet['id']);?>"></td></tr>
			<tr><td>blok</td><td><?php echo($this->lookUp($this->listblok, $this->predmet['blok'], 'blok', 'blok'));?></td></tr>
			<tr><td>predmet</td><td><input type="text" name="predmet" value="<?php echo(htmlspecialchars($this->predmet['predmet']));?>"></td></tr>
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