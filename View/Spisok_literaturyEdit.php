<?php
class Spisok_literaturyEdit{
	var $id;
	var $dbbiblio;
	var $biblio;
var $dbbook_type;
var $listbook_type;
var $dbgrif;
var $listgrif;
var $dblibcat;
var $listlibcat;
function Spisok_literaturyEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbbiblio = new dbbiblio();
		$this->biblio = $this->dbbiblio->get($this->id);
		
$this->dbbook_type = new dbbook_type();
//получаем лист для lookUp
		$this->listbook_type=$this->dbbook_type->load('','',0,0);$this->dbgrif = new dbgrif();
//получаем лист для lookUp
		$this->listgrif=$this->dbgrif->load('','',0,0);$this->dblibcat = new dblibcat();
//получаем лист для lookUp
		$this->listlibcat=$this->dblibcat->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=Spisok_literaturyView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Spisok_literaturyEdit&action=updateSpisok_literaturyAction&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->biblio['id']);?>"></td></tr>
			<tr><td>booktype</td><td><?php echo($this->lookUp($this->listbook_type, $this->biblio['booktype'], 'booktype', 'booktype'));?></td></tr>
			<tr><td>author</td><td><input type="text" name="author" value="<?php echo(htmlspecialchars($this->biblio['author']));?>"></td></tr>
			<tr><td>title</td><td><input type="text" name="title" value="<?php echo(htmlspecialchars($this->biblio['title']));?>"></td></tr>
			<tr><td>dataizd</td><td><input type="text" name="dataizd" id="dataizd_fd" value="<?php echo($this->biblio['dataizd']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'dataizd_fd', 'datetime', 'dataizd_fd');"></td></tr>
			<tr><td>izdatel</td><td><input type="text" name="izdatel" value="<?php echo(htmlspecialchars($this->biblio['izdatel']));?>"></td></tr>
			<tr><td>grif</td><td><?php echo($this->lookUp($this->listgrif, $this->biblio['grif'], 'grif', 'grif'));?></td></tr>
			<tr><td>kolvo</td><td><input type="text" name="kolvo" value="<?php echo($this->biblio['kolvo']);?>"></td></tr>
			<tr><td>libcat</td><td><?php echo($this->lookUp($this->listlibcat, $this->biblio['libcat'], 'libcat', 'libcat'));?></td></tr>
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