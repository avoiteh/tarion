<?php
class dbcategory{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `category`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `category`";
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
$parent = mysql_result($r,$i,'parent');
$category = mysql_result($r,$i,'category');
$list[]=array("id"=>$id, "parent"=>$parent, "category"=>$category);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `category` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$parent = mysql_result($r,$i,'parent');
$category = mysql_result($r,$i,'category');
return array("id"=>$id, "parent"=>$parent, "category"=>$category);
		}else{
			return false;
		}
	}
	function add($parent, $category){
		$sql="INSERT INTO `category`(`parent`, `category`) VALUES('$parent', '$category')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `category` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $parent, $category){
		$sql="UPDATE `category` SET ";
		$d='';if($parent!=null){
				$sql.=$d.' `parent`="'.$parent.'"';
				$d=', ';
			}if($category!=null){
				$sql.=$d.' `category`="'.$category.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>