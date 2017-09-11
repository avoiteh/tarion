<?php
class Spisok_komissiyEdit{
	var $id;
	var $dbkomiss;
	var $komiss;
var $dbfront_user;
var $listfront_user;
function Spisok_komissiyEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbkomiss = new dbkomiss();
		$this->komiss = $this->dbkomiss->get($this->id);
		
$this->dbfront_user = new dbfront_user();
//получаем лист для lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Spisok_komissiyView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Spisok_komissiyEdit&action=updateSpisok_komissiyAction&id=<?=$this->id?>">

			<tr><td>komiss</td><td><input type="text" name="komiss" value="<?php echo(htmlspecialchars($this->komiss['komiss']));?>"></td></tr>
			<tr><td>predsedat</td><td><?php echo($this->lookUp($this->listfront_user, $this->komiss['predsedat'], 'family', 'predsedat'));?></td></tr>
			<tr><td>status</td><td><input type=checkbox name="status" value='1' <?php if($this->komiss['status']!=0){ ?> checked<?php } ?>></td></tr>
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