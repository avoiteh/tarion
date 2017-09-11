<?php
class shabl_prep_planaEdit{
	var $id;
	var $dbplan_shablon;
	var $plan_shablon;
var $dbppr;
var $listppr;
function shabl_prep_planaEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbplan_shablon = new dbplan_shablon();
		$this->plan_shablon = $this->dbplan_shablon->get($this->id);
		
$this->dbppr = new dbppr();
//получаем лист для lookUp
		$this->listppr=$this->dbppr->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=shabl_prep_planaView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=shabl_prep_planaEdit&action=updateshabl_prep_planaAction&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->plan_shablon['id']);?>"></td></tr>
			<tr><td>razdel</td><td><?php echo($this->lookUp($this->listppr, $this->plan_shablon['razdel'], 'razdel', 'razdel'));?></td></tr>
			<tr><td>title</td><td><input type="text" name="title" value="<?php echo(htmlspecialchars($this->plan_shablon['title']));?>"></td></tr>
			<tr><td>shablon</td><td><input type="text" name="shablon" value="<?php echo(htmlspecialchars($this->plan_shablon['shablon']));?>"></td></tr>
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