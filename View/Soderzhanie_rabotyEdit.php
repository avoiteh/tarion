<?php
class Soderzhanie_rabotyEdit{
	var $id;
	var $dbprotokol_cont;
	var $protokol_cont;
var $dbppr;
var $listppr;
var $dbprotokols;
var $listprotokols;
function Soderzhanie_rabotyEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbprotokol_cont = new dbprotokol_cont();
		$this->protokol_cont = $this->dbprotokol_cont->get($this->id);
		
$this->dbppr = new dbppr();
//получаем лист дл€ lookUp
		$this->listppr=$this->dbppr->load('','',0,0);$this->dbprotokols = new dbprotokols();
//получаем лист дл€ lookUp
		$this->listprotokols=$this->dbprotokols->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Soderzhanie_rabotyView'>  списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Soderzhanie_rabotyEdit&action=updateSoderzhanie_rabotyAction&id=<?=$this->id?>">

			<tr><td>preprab</td><td><?php echo($this->lookUp($this->listppr, $this->protokol_cont['preprab'], 'razdel', 'preprab'));?></td></tr>
			<tr><td>protokol</td><td><?php echo($this->lookUp($this->listprotokols, $this->protokol_cont['protokol'], 'komis', 'protokol'));?></td></tr>
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