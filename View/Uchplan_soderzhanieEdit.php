<?php
class Uchplan_soderzhanieEdit{
	var $id;
	var $dbuch_cont;
	var $uch_cont;
var $dbprepod_plan;
var $listprepod_plan;
var $dbpredmet;
var $listpredmet;
function Uchplan_soderzhanieEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbuch_cont = new dbuch_cont();
		$this->uch_cont = $this->dbuch_cont->get($this->id);
		
$this->dbprepod_plan = new dbprepod_plan();
//получаем лист дл€ lookUp
		$this->listprepod_plan=$this->dbprepod_plan->load('','',0,0);$this->dbpredmet = new dbpredmet();
//получаем лист дл€ lookUp
		$this->listpredmet=$this->dbpredmet->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Uchplan_soderzhanieView'>  списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Uchplan_soderzhanieEdit&action=updateUchplan_soderzhanieAction&id=<?=$this->id?>">

			<tr><td>plann</td><td><?php echo($this->lookUp($this->listprepod_plan, $this->uch_cont['plann'], 'remark', 'plann'));?></td></tr>
			<tr><td>indexplan</td><td><input type="text" name="indexplan" value="<?php echo(htmlspecialchars($this->uch_cont['indexplan']));?>"></td></tr>
			<tr><td>predmet</td><td><?php echo($this->lookUp($this->listpredmet, $this->uch_cont['predmet'], 'predmet', 'predmet'));?></td></tr>
			<tr><td>theory</td><td><input type="text" name="theory" value="<?php echo($this->uch_cont['theory']);?>"></td></tr>
			<tr><td>praktik</td><td><input type="text" name="praktik" value="<?php echo($this->uch_cont['praktik']);?>"></td></tr>
			<tr><td>kursov</td><td><input type="text" name="kursov" value="<?php echo($this->uch_cont['kursov']);?>"></td></tr>
			<tr><td>samost</td><td><input type="text" name="samost" value="<?php echo($this->uch_cont['samost']);?>"></td></tr>
			<tr><td>kolvokontrol</td><td><input type="text" name="kolvokontrol" value="<?php echo($this->uch_cont['kolvokontrol']);?>"></td></tr>
			<tr><td>chassem1</td><td><input type="text" name="chassem1" value="<?php echo(htmlspecialchars($this->uch_cont['chassem1']));?>"></td></tr>
			<tr><td>chassem2</td><td><input type="text" name="chassem2" value="<?php echo(htmlspecialchars($this->uch_cont['chassem2']));?>"></td></tr>
			<tr><td>chassem3</td><td><input type="text" name="chassem3" value="<?php echo(htmlspecialchars($this->uch_cont['chassem3']));?>"></td></tr>
			<tr><td>chassem4</td><td><input type="text" name="chassem4" value="<?php echo(htmlspecialchars($this->uch_cont['chassem4']));?>"></td></tr>
			<tr><td>chassem5</td><td><input type="text" name="chassem5" value="<?php echo(htmlspecialchars($this->uch_cont['chassem5']));?>"></td></tr>
			<tr><td>chassem6</td><td><input type="text" name="chassem6" value="<?php echo(htmlspecialchars($this->uch_cont['chassem6']));?>"></td></tr>
			<tr><td>chassem7</td><td><input type="text" name="chassem7" value="<?php echo(htmlspecialchars($this->uch_cont['chassem7']));?>"></td></tr>
			<tr><td>chassem8</td><td><input type="text" name="chassem8" value="<?php echo(htmlspecialchars($this->uch_cont['chassem8']));?>"></td></tr>
			<tr><td>zachsem1</td><td><input type="text" name="zachsem1" value="<?php echo(htmlspecialchars($this->uch_cont['zachsem1']));?>"></td></tr>
			<tr><td>zachsem2</td><td><input type="text" name="zachsem2" value="<?php echo(htmlspecialchars($this->uch_cont['zachsem2']));?>"></td></tr>
			<tr><td>zachsem3</td><td><input type="text" name="zachsem3" value="<?php echo(htmlspecialchars($this->uch_cont['zachsem3']));?>"></td></tr>
			<tr><td>zachsem4</td><td><input type="text" name="zachsem4" value="<?php echo(htmlspecialchars($this->uch_cont['zachsem4']));?>"></td></tr>
			<tr><td>zachsem5</td><td><input type="text" name="zachsem5" value="<?php echo(htmlspecialchars($this->uch_cont['zachsem5']));?>"></td></tr>
			<tr><td>zachsem6</td><td><input type="text" name="zachsem6" value="<?php echo(htmlspecialchars($this->uch_cont['zachsem6']));?>"></td></tr>
			<tr><td>zachsem7</td><td><input type="text" name="zachsem7" value="<?php echo(htmlspecialchars($this->uch_cont['zachsem7']));?>"></td></tr>
			<tr><td>zachsem8</td><td><input type="text" name="zachsem8" value="<?php echo(htmlspecialchars($this->uch_cont['zachsem8']));?>"></td></tr>
			<tr><td>kurssem1</td><td><input type="text" name="kurssem1" value="<?php echo(htmlspecialchars($this->uch_cont['kurssem1']));?>"></td></tr>
			<tr><td>kurssem2</td><td><input type="text" name="kurssem2" value="<?php echo(htmlspecialchars($this->uch_cont['kurssem2']));?>"></td></tr>
			<tr><td>kurssem3</td><td><input type="text" name="kurssem3" value="<?php echo(htmlspecialchars($this->uch_cont['kurssem3']));?>"></td></tr>
			<tr><td>kurssem4</td><td><input type="text" name="kurssem4" value="<?php echo(htmlspecialchars($this->uch_cont['kurssem4']));?>"></td></tr>
			<tr><td>kurssem5</td><td><input type="text" name="kurssem5" value="<?php echo(htmlspecialchars($this->uch_cont['kurssem5']));?>"></td></tr>
			<tr><td>kurssem6</td><td><input type="text" name="kurssem6" value="<?php echo(htmlspecialchars($this->uch_cont['kurssem6']));?>"></td></tr>
			<tr><td>kurssem7</td><td><input type="text" name="kurssem7" value="<?php echo(htmlspecialchars($this->uch_cont['kurssem7']));?>"></td></tr>
			<tr><td>kurssem8</td><td><input type="text" name="kurssem8" value="<?php echo(htmlspecialchars($this->uch_cont['kurssem8']));?>"></td></tr>
			<tr><td>kontrsem1</td><td><input type="text" name="kontrsem1" value="<?php echo(htmlspecialchars($this->uch_cont['kontrsem1']));?>"></td></tr>
			<tr><td>kontrsem2</td><td><input type="text" name="kontrsem2" value="<?php echo(htmlspecialchars($this->uch_cont['kontrsem2']));?>"></td></tr>
			<tr><td>kontrsem3</td><td><input type="text" name="kontrsem3" value="<?php echo(htmlspecialchars($this->uch_cont['kontrsem3']));?>"></td></tr>
			<tr><td>kontrsem4</td><td><input type="text" name="kontrsem4" value="<?php echo(htmlspecialchars($this->uch_cont['kontrsem4']));?>"></td></tr>
			<tr><td>kontrsem5</td><td><input type="text" name="kontrsem5" value="<?php echo(htmlspecialchars($this->uch_cont['kontrsem5']));?>"></td></tr>
			<tr><td>kontrsem6</td><td><input type="text" name="kontrsem6" value="<?php echo(htmlspecialchars($this->uch_cont['kontrsem6']));?>"></td></tr>
			<tr><td>kontrsem7</td><td><input type="text" name="kontrsem7" value="<?php echo(htmlspecialchars($this->uch_cont['kontrsem7']));?>"></td></tr>
			<tr><td>kontrsem8</td><td><input type="text" name="kontrsem8" value="<?php echo(htmlspecialchars($this->uch_cont['kontrsem8']));?>"></td></tr>
			<tr><td>examsem1</td><td><input type="text" name="examsem1" value="<?php echo(htmlspecialchars($this->uch_cont['examsem1']));?>"></td></tr>
			<tr><td>examsem2</td><td><input type="text" name="examsem2" value="<?php echo(htmlspecialchars($this->uch_cont['examsem2']));?>"></td></tr>
			<tr><td>examsem3</td><td><input type="text" name="examsem3" value="<?php echo(htmlspecialchars($this->uch_cont['examsem3']));?>"></td></tr>
			<tr><td>examsem4</td><td><input type="text" name="examsem4" value="<?php echo(htmlspecialchars($this->uch_cont['examsem4']));?>"></td></tr>
			<tr><td>examsem5</td><td><input type="text" name="examsem5" value="<?php echo(htmlspecialchars($this->uch_cont['examsem5']));?>"></td></tr>
			<tr><td>examsem6</td><td><input type="text" name="examsem6" value="<?php echo(htmlspecialchars($this->uch_cont['examsem6']));?>"></td></tr>
			<tr><td>examsem7</td><td><input type="text" name="examsem7" value="<?php echo(htmlspecialchars($this->uch_cont['examsem7']));?>"></td></tr>
			<tr><td>examsem8</td><td><input type="text" name="examsem8" value="<?php echo(htmlspecialchars($this->uch_cont['examsem8']));?>"></td></tr>
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