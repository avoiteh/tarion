<?php
class Kategorii_BOEditBO{
	var $id;
	var $dbcategory;
	var $category;
function Kategorii_BOEditBO(){
		$this->id=$_REQUEST['id']*1;
		$this->dbcategory = new dbcategory();
		$this->category = $this->dbcategory->get($this->id);
		

	}
	function Paint(){
		?>
		<a href='?view=Kategorii_BOViewBO'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=Kategorii_BOEditBO&action=updateKategorii_BOActionBO&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->category['id']);?>"></td></tr>
			<tr><td>category</td><td><input type="text" name="category" value="<?php echo($this->category['category']);?>"></td></tr>
		<tr><td colspan="2"><input value=" O.K. " type="submit"></td></tr>
		</form>
		</table>
		<?php
	}
	function lookUp(&$list, $id, $field_name, $name){
		$s="<select name='$name'>
		<option value=0> --- </option>
";
		if(is_array($list)){
			foreach ($list as $rec){
				$s.="<option value=''";
				if($rec['id']==$id){
					$s.=" selected";
				}
				$s.=">$rec[$field_name]</option>
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