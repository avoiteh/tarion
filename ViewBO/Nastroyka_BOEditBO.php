<?php
class Nastroyka_BOEditBO{
	var $id;
	var $dbcross_right;
	var $cross_right;
var $dbmodules;
var $listmodules;
var $dbright;
var $listright;
function Nastroyka_BOEditBO(){
		$this->id=$_REQUEST['id']*1;
		$this->dbcross_right = new dbcross_right();
		$this->cross_right = $this->dbcross_right->get($this->id);
		
$this->dbmodules = new dbmodules();
//получаем лист дл€ lookUp
		$this->listmodules=$this->dbmodules->load('','',0,0);$this->dbright = new dbright();
//получаем лист дл€ lookUp
		$this->listright=$this->dbright->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Nastroyka_BOViewBO'>  списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Nastroyka_BOEditBO&action=updateNastroyka_BOActionBO&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->cross_right['id']);?>"></td></tr>
			<tr><td>module</td><td><?php echo($this->lookUp($this->listmodules, $this->cross_right['module'], 'module', 'module'));?></td></tr>
			<tr><td>right</td><td><?php echo($this->lookUp($this->listright, $this->cross_right['right'], 'name', 'right'));?></td></tr>
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