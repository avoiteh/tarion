<?php
class dbproduct{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `product`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `product`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		if($order!=""){
			$sql.=" ORDER $order";
		}
		if($limit>0){
			$sql.=" LIMIT $start, $limit";
		}
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		$list=array();
		for($i=0;$i<$n;$i++){
			$id=mysql_result($r,$i,"id");
$category = mysql_result($r,$i,'category');
$name = mysql_result($r,$i,'name');
$desc = mysql_result($r,$i,'desc');
$photo = mysql_result($r,$i,'photo');
$list[]=array("id"=>$id, "category"=>$category, "name"=>$name, "desc"=>$desc, "photo"=>$photo);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `product` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$category = mysql_result($r,$i,'category');
$name = mysql_result($r,$i,'name');
$desc = mysql_result($r,$i,'desc');
$photo = mysql_result($r,$i,'photo');
return array("id"=>$id, "category"=>$category, "name"=>$name, "desc"=>$desc, "photo"=>$photo);
		}else{
			return false;
		}
	}
	function add($category, $name, $desc, $photo){
		$sql="INSERT INTO `product`(`category`, `name`, `desc`, `photo`) VALUES('$category', '$name', '$desc', '$photo')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `product` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $category, $name, $desc, $photo){
		$sql="UPDATE `product` SET ";
		$d='';if($category!=null){
				$sql.=$d.' `category`="'.$category.'"';
				$d=', ';
			}if($name!=null){
				$sql.=$d.' `name`="'.$name.'"';
				$d=', ';
			}if($desc!=null){
				$sql.=$d.' `desc`="'.$desc.'"';
				$d=', ';
			}if($photo!=null){
				$sql.=$d.' `photo`="'.$photo.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>