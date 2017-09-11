<?php
class Raspisanie_punktyEdit{
	var $id;
	var $dbraspisanie;
	var $raspisanie;
var $dbpredmet;
var $listpredmet;
var $dbgruppa;
var $listgruppa;
var $dbfront_user;
var $listfront_user;
var $dbkabinet;
var $listkabinet;
function Raspisanie_punktyEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbraspisanie = new dbraspisanie();
		$this->raspisanie = $this->dbraspisanie->get($this->id);
		
$this->dbpredmet = new dbpredmet();
//получаем лист для lookUp
		$this->listpredmet=$this->dbpredmet->load('','',0,0);$this->dbgruppa = new dbgruppa();
//получаем лист для lookUp
		$this->listgruppa=$this->dbgruppa->load('','',0,0);$this->dbfront_user = new dbfront_user();
//получаем лист для lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);$this->dbkabinet = new dbkabinet();
//получаем лист для lookUp
		$this->listkabinet=$this->dbkabinet->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Raspisanie_punktyView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Raspisanie_punktyEdit&action=updateRaspisanie_punktyAction&id=<?=$this->id?>">

			<tr><td>week</td><td><input type="text" name="week" value="<?php echo(htmlspecialchars($this->raspisanie['week']));?>"></td></tr>
			<tr><td>predmet</td><td><?php echo($this->lookUp($this->listpredmet, $this->raspisanie['predmet'], 'predmet', 'predmet'));?></td></tr>
			<tr><td>gruppa</td><td><?php echo($this->lookUp($this->listgruppa, $this->raspisanie['gruppa'], 'gruppa', 'gruppa'));?></td></tr>
			<tr><td>prepod</td><td><?php echo($this->lookUp($this->listfront_user, $this->raspisanie['prepod'], 'family', 'prepod'));?></td></tr>
			<tr><td>den</td><td><input type="text" name="den" value="<?php echo($this->raspisanie['den']);?>"></td></tr>
			<tr><td>para</td><td><input type="text" name="para" value="<?php echo($this->raspisanie['para']);?>"></td></tr>
			<tr><td>kabinet</td><td><?php echo($this->lookUp($this->listkabinet, $this->raspisanie['kabinet'], 'kabinet', 'kabinet'));?></td></tr>
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