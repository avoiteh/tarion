<?php
class Rabota_prepEdit{
	var $id;
	var $dbprepod_plan;
	var $prepod_plan;
var $dbfront_user;
var $listfront_user;
var $dbkomiss;
var $listkomiss;
function Rabota_prepEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbprepod_plan = new dbprepod_plan();
		$this->prepod_plan = $this->dbprepod_plan->get($this->id);
		
$this->dbfront_user = new dbfront_user();
//получаем лист дл€ lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);$this->dbkomiss = new dbkomiss();
//получаем лист дл€ lookUp
		$this->listkomiss=$this->dbkomiss->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Rabota_prepView'>  списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Rabota_prepEdit&action=updateRabota_prepAction&id=<?=$this->id?>">

			<tr><td>prepod</td><td><?php echo($this->lookUp($this->listfront_user, $this->prepod_plan['prepod'], 'family', 'prepod'));?></td></tr>
			<tr><td>komiss</td><td><?php echo($this->lookUp($this->listkomiss, $this->prepod_plan['komiss'], 'komiss', 'komiss'));?></td></tr>
			<tr><td>god</td><td><input type="text" name="god" value="<?php echo($this->prepod_plan['god']);?>"></td></tr>
			<tr><td>remark</td><td><input type="text" name="remark" value="<?php echo(htmlspecialchars($this->prepod_plan['remark']));?>"></td></tr>
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