<?php
class Plan_prep__soderzhanieEdit{
	var $id;
	var $dbprepod_cont;
	var $prepod_cont;
var $dbprepod_plan;
var $listprepod_plan;
var $dbppr;
var $listppr;
function Plan_prep__soderzhanieEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbprepod_cont = new dbprepod_cont();
		$this->prepod_cont = $this->dbprepod_cont->get($this->id);
		
$this->dbprepod_plan = new dbprepod_plan();
//получаем лист дл€ lookUp
		$this->listprepod_plan=$this->dbprepod_plan->load('','',0,0);$this->dbppr = new dbppr();
//получаем лист дл€ lookUp
		$this->listppr=$this->dbppr->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Plan_prep__soderzhanieView'>  списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Plan_prep__soderzhanieEdit&action=updatePlan_prep__soderzhanieAction&id=<?=$this->id?>">

			<tr><td>plann</td><td><?php echo($this->lookUp($this->listprepod_plan, $this->prepod_cont['plann'], 'remark', 'plann'));?></td></tr>
			<tr><td>tip</td><td><?php echo($this->lookUp($this->listppr, $this->prepod_cont['tip'], 'razdel', 'tip'));?></td></tr>
			<tr><td>opis</td><td><input type="text" name="opis" value="<?php echo(htmlspecialchars($this->prepod_cont['opis']));?>"></td></tr>
			<tr><td>srok</td><td><input type="text" name="srok" id="srok_fd" value="<?php echo($this->prepod_cont['srok']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'srok_fd', 'datetime', 'srok_fd');"></td></tr>
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