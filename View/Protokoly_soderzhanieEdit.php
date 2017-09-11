<?php
class Protokoly_soderzhanieEdit{
	var $id;
	var $dbprotokols;
	var $protokols;
var $dbkomiss;
var $listkomiss;
function Protokoly_soderzhanieEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbprotokols = new dbprotokols();
		$this->protokols = $this->dbprotokols->get($this->id);
		
$this->dbkomiss = new dbkomiss();
//получаем лист для lookUp
		$this->listkomiss=$this->dbkomiss->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Protokoly_soderzhanieView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Protokoly_soderzhanieEdit&action=updateProtokoly_soderzhanieAction&id=<?=$this->id?>">

			<tr><td>komis</td><td><?php echo($this->lookUp($this->listkomiss, $this->protokols['komis'], 'komiss', 'komis'));?></td></tr>
			<tr><td>datakomis</td><td><input type="text" name="datakomis" id="datakomis_fd" value="<?php echo($this->protokols['datakomis']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'datakomis_fd', 'datetime', 'datakomis_fd');"></td></tr>
			<tr><td>nomer</td><td><input type="text" name="nomer" value="<?php echo(htmlspecialchars($this->protokols['nomer']));?>"></td></tr>
			<tr><td>status</td><td><input type=checkbox name="status" value='1' <?php if($this->protokols['status']!=0){ ?> checked<?php } ?>></td></tr>
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