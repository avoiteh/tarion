<?php
class Nastroyka_FOEditBO{
	var $id;
	var $dbfront_cross_right;
	var $front_cross_right;
var $dbfront_modules;
var $listfront_modules;
var $dbfront_right;
var $listfront_right;
function Nastroyka_FOEditBO(){
		$this->id=$_REQUEST['id']*1;
		$this->dbfront_cross_right = new dbfront_cross_right();
		$this->front_cross_right = $this->dbfront_cross_right->get($this->id);
		
$this->dbfront_modules = new dbfront_modules();
//получаем лист дл€ lookUp
		$this->listfront_modules=$this->dbfront_modules->load('','',0,0);$this->dbfront_right = new dbfront_right();
//получаем лист дл€ lookUp
		$this->listfront_right=$this->dbfront_right->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Nastroyka_FOViewBO'>  списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Nastroyka_FOEditBO&action=updateNastroyka_FOActionBO&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->front_cross_right['id']);?>"></td></tr>
			<tr><td>module</td><td><?php echo($this->lookUp($this->listfront_modules, $this->front_cross_right['module'], 'module', 'module'));?></td></tr>
			<tr><td>right</td><td><?php echo($this->lookUp($this->listfront_right, $this->front_cross_right['right'], 'name', 'right'));?></td></tr>
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