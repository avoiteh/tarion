<?php
class GruppyEdit{
	var $id;
	var $dbgruppa;
	var $gruppa;
var $dbtop_spec;
var $listtop_spec;
function GruppyEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbgruppa = new dbgruppa();
		$this->gruppa = $this->dbgruppa->get($this->id);
		
$this->dbtop_spec = new dbtop_spec();
//получаем лист для lookUp
		$this->listtop_spec=$this->dbtop_spec->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=GruppyView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=GruppyEdit&action=updateGruppyAction&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->gruppa['id']);?>"></td></tr>
			<tr><td>gruppa</td><td><input type="text" name="gruppa" value="<?php echo(htmlspecialchars($this->gruppa['gruppa']));?>"></td></tr>
			<tr><td>special</td><td><?php echo($this->lookUp($this->listtop_spec, $this->gruppa['special'], 'topspec', 'special'));?></td></tr>
			<tr><td>kurs</td><td><input type="text" name="kurs" value="<?php echo($this->gruppa['kurs']);?>"></td></tr>
			<tr><td>sozdan</td><td><input type="text" name="sozdan" id="sozdan_fd" value="<?php echo($this->gruppa['sozdan']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'sozdan_fd', 'datetime', 'sozdan_fd');"></td></tr>
			<tr><td>status</td><td><input type=checkbox name="status" value='1' <?php if($this->gruppa['status']!=0){ ?> checked<?php } ?>></td></tr>
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