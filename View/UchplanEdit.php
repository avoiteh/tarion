<?php
class UchplanEdit{
	var $id;
	var $dbuch_plan;
	var $uch_plan;
var $dbfront_user;
var $listfront_user;
var $dbspecial;
var $listspecial;
function UchplanEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbuch_plan = new dbuch_plan();
		$this->uch_plan = $this->dbuch_plan->get($this->id);
		
$this->dbfront_user = new dbfront_user();
//получаем лист дл€ lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);$this->dbspecial = new dbspecial();
//получаем лист дл€ lookUp
		$this->listspecial=$this->dbspecial->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=UchplanView'>  списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=UchplanEdit&action=updateUchplanAction&id=<?=$this->id?>">

			<tr><td>prepod</td><td><?php echo($this->lookUp($this->listfront_user, $this->uch_plan['prepod'], 'email', 'prepod'));?></td></tr>
			<tr><td>god</td><td><input type="text" name="god" value="<?php echo(htmlspecialchars($this->uch_plan['god']));?>"></td></tr>
			<tr><td>naim</td><td><input type="text" name="naim" value="<?php echo(htmlspecialchars($this->uch_plan['naim']));?>"></td></tr>
			<tr><td>special</td><td><?php echo($this->lookUp($this->listspecial, $this->uch_plan['special'], 'special', 'special'));?></td></tr>
			<tr><td>sem1</td><td><input type="text" name="sem1" value="<?php echo($this->uch_plan['sem1']);?>"></td></tr>
			<tr><td>sem2</td><td><input type="text" name="sem2" value="<?php echo($this->uch_plan['sem2']);?>"></td></tr>
			<tr><td>sem3</td><td><input type="text" name="sem3" value="<?php echo($this->uch_plan['sem3']);?>"></td></tr>
			<tr><td>sem4</td><td><input type="text" name="sem4" value="<?php echo($this->uch_plan['sem4']);?>"></td></tr>
			<tr><td>sem5</td><td><input type="text" name="sem5" value="<?php echo($this->uch_plan['sem5']);?>"></td></tr>
			<tr><td>sem6</td><td><input type="text" name="sem6" value="<?php echo($this->uch_plan['sem6']);?>"></td></tr>
			<tr><td>sem7</td><td><input type="text" name="sem7" value="<?php echo($this->uch_plan['sem7']);?>"></td></tr>
			<tr><td>sem8</td><td><input type="text" name="sem8" value="<?php echo($this->uch_plan['sem8']);?>"></td></tr>
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