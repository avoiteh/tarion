<?php
class Polzovateli_FOEditBO{
	var $id;
	var $dbfront_user;
	var $front_user;
var $dbfront_right;
var $listfront_right;
function Polzovateli_FOEditBO(){
		$this->id=$_REQUEST['id']*1;
		$this->dbfront_user = new dbfront_user();
		$this->front_user = $this->dbfront_user->get($this->id);
		
$this->dbfront_right = new dbfront_right();
//получаем лист для lookUp
		$this->listfront_right=$this->dbfront_right->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Polzovateli_FOViewBO'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Polzovateli_FOEditBO&action=updatePolzovateli_FOActionBO&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->front_user['id']);?>"></td></tr>
			<tr><td>email</td><td><input type="text" name="email" value="<?php echo(htmlspecialchars($this->front_user['email']));?>"></td></tr>
			<tr><td>password</td><td><input type="text" name="password" value="<?php echo(htmlspecialchars($this->front_user['password']));?>"></td></tr>
			<tr><td>right</td><td><?php echo($this->lookUp($this->listfront_right, $this->front_user['right'], 'name', 'right'));?></td></tr>
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