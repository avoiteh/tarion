<?php
class Sostav_komissiiEdit{
	var $id;
	var $dbsostav_komis;
	var $sostav_komis;
var $dbkomiss;
var $listkomiss;
var $dbfront_user;
var $listfront_user;
function Sostav_komissiiEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbsostav_komis = new dbsostav_komis();
		$this->sostav_komis = $this->dbsostav_komis->get($this->id);
		
$this->dbkomiss = new dbkomiss();
//получаем лист дл€ lookUp
		$this->listkomiss=$this->dbkomiss->load('','',0,0);$this->dbfront_user = new dbfront_user();
//получаем лист дл€ lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Sostav_komissiiView'>  списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Sostav_komissiiEdit&action=updateSostav_komissiiAction&id=<?=$this->id?>">

			<tr><td>komis</td><td><?php echo($this->lookUp($this->listkomiss, $this->sostav_komis['komis'], 'komiss', 'komis'));?></td></tr>
			<tr><td>prepod</td><td><?php echo($this->lookUp($this->listfront_user, $this->sostav_komis['prepod'], 'family', 'prepod'));?></td></tr>
			<tr><td>status</td><td><input type=checkbox name="status" value='1' <?php if($this->sostav_komis['status']!=0){ ?> checked<?php } ?>></td></tr>
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