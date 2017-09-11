<?php
class editProductViewBO{
	var $id;
	var $dbproduct;
	var $product;
	var $dbcategory;
	var $listcategory;
	function editProductViewBO(){
		$this->id=$_REQUEST['id']*1;
		$this->dbproduct = new dbproduct();
		$this->product = $this->dbproduct->get($this->id);
		$this->dbcategory = new dbcategory();
		$this->listcategory = $this->dbcategory->load('','',0,0);
	}
	function Paint(){
		?>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=editProductViewBO&id=<?=$this->id?>">
		<tr><td>id</td><td><?=$this->product['id']?></td></tr>
		<tr><td>category</td><td><?php echo($this->lookUp($this->listcategory, $this->product['category'], 'category', 'category'));?></td></tr>
		<tr><td>name</td><td><input type="text" name="name" value="<?=$this->product['name']?>"></td></tr>
		<tr><td>desc</td><td><textarea name="desc"><?=$this->product['desc']?></textarea></td></tr>
		<tr><td>photo</td><td>
			<img src="<?php echo(photoPath($this->product['photo']));?>">
			<br><input type="file" name="photo">
			</td></tr>
		<tr><td colspan="2"><input value=" O.K. " type="submit"></td></tr>
		</form>
		</table>
		<?php
	}
	function lookUp(&$list, $id, $field_name, $name){
		$s="<select name='$name'>
";
		if(is_array($list)){
			foreach ($list as $rec){
				$s.="<option value=''";
				if($rec['id']==$id){
					$s.=" select";
				}
				$s.=">$rec[$field_name]</option>
";
			}
		}
		$s.="</select>
";
		return $s;
	}
}
?>