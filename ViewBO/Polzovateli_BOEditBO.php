<?php
class Polzovateli_BOEditBO{
	var $id;
	var $dbuser;
	var $user;
var $dbright;
var $listright;
function Polzovateli_BOEditBO(){
		$this->id=$_REQUEST['id']*1;
		$this->dbuser = new dbuser();
		$this->user = $this->dbuser->get($this->id);
		
$this->dbright = new dbright();
//получаем лист для lookUp
		$this->listright=$this->dbright->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Polzovateli_BOViewBO'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Polzovateli_BOEditBO&action=updatePolzovateli_BOActionBO&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->user['id']);?>"></td></tr>
			<tr><td>login</td><td><input type="text" name="login" value="<?php echo(htmlspecialchars($this->user['login']));?>"></td></tr>
			<tr><td>password</td><td><input type="text" name="password" value="<?php echo(htmlspecialchars($this->user['password']));?>"></td></tr>
			<tr><td>email</td><td><input type="text" name="email" value="<?php echo(htmlspecialchars($this->user['email']));?>"></td></tr>
			<tr><td>right</td><td><?php echo($this->lookUp($this->listright, $this->user['right'], 'name', 'right'));?></td></tr>
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