<?php
class Metod_razrabotkiEdit{
	var $id;
	var $dbreg_book;
	var $reg_book;
var $dbfront_user;
var $listfront_user;
var $dbprotokols;
var $listprotokols;
var $dbkomiss;
var $listkomiss;
function Metod_razrabotkiEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbreg_book = new dbreg_book();
		$this->reg_book = $this->dbreg_book->get($this->id);
		
$this->dbfront_user = new dbfront_user();
//получаем лист для lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);$this->dbprotokols = new dbprotokols();
//получаем лист для lookUp
		$this->listprotokols=$this->dbprotokols->load('','',0,0);$this->dbkomiss = new dbkomiss();
//получаем лист для lookUp
		$this->listkomiss=$this->dbkomiss->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Metod_razrabotkiView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Metod_razrabotkiEdit&action=updateMetod_razrabotkiAction&id=<?=$this->id?>">

			<tr><td>datareg</td><td><input type="text" name="datareg" id="datareg_fd" value="<?php echo($this->reg_book['datareg']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'datareg_fd', 'datetime', 'datareg_fd');"></td></tr>
			<tr><td>nomer</td><td><input type="text" name="nomer" value="<?php echo(htmlspecialchars($this->reg_book['nomer']));?>"></td></tr>
			<tr><td>naim</td><td><input type="text" name="naim" value="<?php echo(htmlspecialchars($this->reg_book['naim']));?>"></td></tr>
			<tr><td>prepod</td><td><?php echo($this->lookUp($this->listfront_user, $this->reg_book['prepod'], 'family', 'prepod'));?></td></tr>
			<tr><td>komprot</td><td><?php echo($this->lookUp($this->listprotokols, $this->reg_book['komprot'], 'nomer', 'komprot'));?></td></tr>
			<tr><td>komis</td><td><?php echo($this->lookUp($this->listkomiss, $this->reg_book['komis'], 'komiss', 'komis'));?></td></tr>
			<tr><td>status</td><td><input type=checkbox name="status" value='1' <?php if($this->reg_book['status']!=0){ ?> checked<?php } ?>></td></tr>
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