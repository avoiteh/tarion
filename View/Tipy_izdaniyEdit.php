<?php
class Tipy_izdaniyEdit{
	var $id;
	var $dbbook_type;
	var $book_type;
function Tipy_izdaniyEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbbook_type = new dbbook_type();
		$this->book_type = $this->dbbook_type->get($this->id);
		

	}
	function Paint(){
		?>
		<a href='?view=Tipy_izdaniyView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Tipy_izdaniyEdit&action=updateTipy_izdaniyAction&id=<?=$this->id?>">

			<tr><td>booktype</td><td><input type="text" name="booktype" value="<?php echo(htmlspecialchars($this->book_type['booktype']));?>"></td></tr>
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