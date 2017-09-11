<?php
class Vedomost_nadb_i_vychEdit{
	var $id;
	var $dbvednadbvych;
	var $vednadbvych;
var $dbfront_user;
var $listfront_user;
var $dbnadbvych;
var $listnadbvych;
function Vedomost_nadb_i_vychEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbvednadbvych = new dbvednadbvych();
		$this->vednadbvych = $this->dbvednadbvych->get($this->id);
		
$this->dbfront_user = new dbfront_user();
//получаем лист дл€ lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);$this->dbnadbvych = new dbnadbvych();
//получаем лист дл€ lookUp
		$this->listnadbvych=$this->dbnadbvych->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Vedomost_nadb_i_vychView'>  списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Vedomost_nadb_i_vychEdit&action=updateVedomost_nadb_i_vychAction&id=<?=$this->id?>">

			<tr><td>prepod</td><td><?php echo($this->lookUp($this->listfront_user, $this->vednadbvych['prepod'], 'family', 'prepod'));?></td></tr>
			<tr><td>tip</td><td><?php echo($this->lookUp($this->listnadbvych, $this->vednadbvych['tip'], 'naim', 'tip'));?></td></tr>
			<tr><td>god</td><td><input type="text" name="god" value="<?php echo(htmlspecialchars($this->vednadbvych['god']));?>"></td></tr>
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