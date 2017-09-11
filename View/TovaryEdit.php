<?php
class TovaryEdit{
	var $id;
	var $dbproduct;
	var $product;
var $dbcategory;
var $listcategory;
function TovaryEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbproduct = new dbproduct();
		$this->product = $this->dbproduct->get($this->id);
		
$this->dbcategory = new dbcategory();
//получаем лист для lookUp
		$this->listcategory=$this->dbcategory->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=TovaryView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=TovaryEdit&action=updateTovaryAction&id=<?=$this->id?>">

			<tr><td>ID</td><td><input type="text" name="id" value="<?php echo($this->product['id']);?>"></td></tr>
			<tr><td>category</td><td><?php echo($this->lookUp($this->listcategory, $this->product['category'], 'category', 'category'));?></td></tr>
			<tr><td>name</td><td><input type="text" name="name" value="<?php echo($this->product['name']);?>"></td></tr>
			<tr><td>desc</td><td><textarea name="desc"><?php echo($this->product['desc']);?></textarea></td></tr>
			<tr><td>photo</td><td><?php echo($this->photo($this->id, 'photo'));?><br><input type="file" name="photo"></td></tr>
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