<?php
class PednagruzkaEdit{
	var $id;
	var $dbped_nagr;
	var $ped_nagr;
var $dbfront_user;
var $listfront_user;
var $dbpredmet;
var $listpredmet;
var $dbgruppa;
var $listgruppa;
function PednagruzkaEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbped_nagr = new dbped_nagr();
		$this->ped_nagr = $this->dbped_nagr->get($this->id);
		
$this->dbfront_user = new dbfront_user();
//получаем лист для lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);$this->dbpredmet = new dbpredmet();
//получаем лист для lookUp
		$this->listpredmet=$this->dbpredmet->load('','',0,0);$this->dbgruppa = new dbgruppa();
//получаем лист для lookUp
		$this->listgruppa=$this->dbgruppa->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=PednagruzkaView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=PednagruzkaEdit&action=updatePednagruzkaAction&id=<?=$this->id?>">

			<tr><td>god</td><td><input type="text" name="god" value="<?php echo(htmlspecialchars($this->ped_nagr['god']));?>"></td></tr>
			<tr><td>prepod</td><td><?php echo($this->lookUp($this->listfront_user, $this->ped_nagr['prepod'], 'family', 'prepod'));?></td></tr>
			<tr><td>predmet</td><td><?php echo($this->lookUp($this->listpredmet, $this->ped_nagr['predmet'], 'predmet', 'predmet'));?></td></tr>
			<tr><td>gruppa</td><td><?php echo($this->lookUp($this->listgruppa, $this->ped_nagr['gruppa'], 'gruppa', 'gruppa'));?></td></tr>
			<tr><td>theory</td><td><input type="text" name="theory" value="<?php echo($this->ped_nagr['theory']);?>"></td></tr>
			<tr><td>praktik</td><td><input type="text" name="praktik" value="<?php echo($this->ped_nagr['praktik']);?>"></td></tr>
			<tr><td>kurs</td><td><input type="text" name="kurs" value="<?php echo($this->ped_nagr['kurs']);?>"></td></tr>
			<tr><td>kurstest</td><td><input type="text" name="kurstest" value="<?php echo($this->ped_nagr['kurstest']);?>"></td></tr>
			<tr><td>examine</td><td><input type="text" name="examine" value="<?php echo($this->ped_nagr['examine']);?>"></td></tr>
			<tr><td>allhour</td><td><input type="text" name="allhour" value="<?php echo($this->ped_nagr['allhour']);?>"></td></tr>
			<tr><td>sem1chas</td><td><input type="text" name="sem1chas" value="<?php echo($this->ped_nagr['sem1chas']);?>"></td></tr>
			<tr><td>sem1ned</td><td><input type="text" name="sem1ned" value="<?php echo($this->ped_nagr['sem1ned']);?>"></td></tr>
			<tr><td>sem2chas</td><td><input type="text" name="sem2chas" value="<?php echo($this->ped_nagr['sem2chas']);?>"></td></tr>
			<tr><td>sem2ned</td><td><input type="text" name="sem2ned" value="<?php echo($this->ped_nagr['sem2ned']);?>"></td></tr>
			<tr><td>sem1vych</td><td><input type="text" name="sem1vych" value="<?php echo($this->ped_nagr['sem1vych']);?>"></td></tr>
			<tr><td>sem2vych</td><td><input type="text" name="sem2vych" value="<?php echo($this->ped_nagr['sem2vych']);?>"></td></tr>
			<tr><td>prikaz</td><td><input type="text" name="prikaz" value="<?php echo($this->ped_nagr['prikaz']);?>"></td></tr>
			<tr><td>remark</td><td><input type="text" name="remark" value="<?php echo(htmlspecialchars($this->ped_nagr['remark']));?>"></td></tr>
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