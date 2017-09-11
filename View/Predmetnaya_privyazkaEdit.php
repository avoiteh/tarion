<?php
class Predmetnaya_privyazkaEdit{
	var $id;
	var $dbppl;
	var $ppl;
var $dbbiblio;
var $listbiblio;
var $dbpredmet;
var $listpredmet;
function Predmetnaya_privyazkaEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbppl = new dbppl();
		$this->ppl = $this->dbppl->get($this->id);
		
$this->dbbiblio = new dbbiblio();
//получаем лист дл€ lookUp
		$this->listbiblio=$this->dbbiblio->load('','',0,0);$this->dbpredmet = new dbpredmet();
//получаем лист дл€ lookUp
		$this->listpredmet=$this->dbpredmet->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Predmetnaya_privyazkaView'>  списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Predmetnaya_privyazkaEdit&action=updatePredmetnaya_privyazkaAction&id=<?=$this->id?>">

			<tr><td>biblio</td><td><?php echo($this->lookUp($this->listbiblio, $this->ppl['biblio'], 'title', 'biblio'));?></td></tr>
			<tr><td>predmet</td><td><?php echo($this->lookUp($this->listpredmet, $this->ppl['predmet'], 'predmet', 'predmet'));?></td></tr>
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