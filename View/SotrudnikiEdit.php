<?php
class SotrudnikiEdit{
	var $id;
	var $dbfront_user;
	var $front_user;
var $dbfront_right;
var $listfront_right;
var $dbkabinet;
var $listkabinet;
function SotrudnikiEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbfront_user = new dbfront_user();
		$this->front_user = $this->dbfront_user->get($this->id);
		
$this->dbfront_right = new dbfront_right();
//получаем лист дл€ lookUp
		$this->listfront_right=$this->dbfront_right->load('','',0,0);$this->dbkabinet = new dbkabinet();
//получаем лист дл€ lookUp
		$this->listkabinet=$this->dbkabinet->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=SotrudnikiView'>  списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=SotrudnikiEdit&action=updateSotrudnikiAction&id=<?=$this->id?>">

			<tr><td>email</td><td><input type="text" name="email" value="<?php echo(htmlspecialchars($this->front_user['email']));?>"></td></tr>
			<tr><td>password</td><td><input type="text" name="password" value="<?php echo(htmlspecialchars($this->front_user['password']));?>"></td></tr>
			<tr><td>right</td><td><?php echo($this->lookUp($this->listfront_right, $this->front_user['right'], 'name', 'right'));?></td></tr>
			<tr><td>login</td><td><input type="text" name="login" value="<?php echo(htmlspecialchars($this->front_user['login']));?>"></td></tr>
			<tr><td>family</td><td><input type="text" name="family" value="<?php echo(htmlspecialchars($this->front_user['family']));?>"></td></tr>
			<tr><td>name</td><td><input type="text" name="name" value="<?php echo(htmlspecialchars($this->front_user['name']));?>"></td></tr>
			<tr><td>otch</td><td><input type="text" name="otch" value="<?php echo(htmlspecialchars($this->front_user['otch']));?>"></td></tr>
			<tr><td>dataworkstart</td><td><input type="text" name="dataworkstart" id="dataworkstart_fd" value="<?php echo($this->front_user['dataworkstart']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'dataworkstart_fd', 'datetime', 'dataworkstart_fd');"></td></tr>
			<tr><td>razryd</td><td><input type="text" name="razryd" value="<?php echo($this->front_user['razryd']);?>"></td></tr>
			<tr><td>category</td><td><input type="text" name="category" value="<?php echo($this->front_user['category']);?>"></td></tr>
			<tr><td>kabinet</td><td><?php echo($this->lookUp($this->listkabinet, $this->front_user['kabinet'], 'kabinet', 'kabinet'));?></td></tr>
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