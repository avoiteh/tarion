<?php
class dbbook_type{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `book_type`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `book_type`";
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
$booktype = mysql_result($r,$i,'booktype');
$list[]=array("id"=>$id, "booktype"=>$booktype);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `book_type` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$booktype = mysql_result($r,$i,'booktype');
return array("id"=>$id, "booktype"=>$booktype);
		}else{
			return false;
		}
	}
	function add($booktype){
		$sql="INSERT INTO `book_type`(`booktype`) VALUES('$booktype')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `book_type` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $booktype){
		$sql="UPDATE `book_type` SET ";
		$d='';if($booktype!==null){
				$sql.=$d.' `booktype`="'.$booktype.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>