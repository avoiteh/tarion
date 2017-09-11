<?php
class dbfront_right{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `front_right`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `front_right`";
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
$name = mysql_result($r,$i,'name');
$list[]=array("id"=>$id, "name"=>$name);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `front_right` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$name = mysql_result($r,$i,'name');
return array("id"=>$id, "name"=>$name);
		}else{
			return false;
		}
	}
	function add($name){
		$sql="INSERT INTO `front_right`(`name`) VALUES('$name')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `front_right` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $name){
		$sql="UPDATE `front_right` SET ";
		$d='';if($name!==null){
				$sql.=$d.' `name`="'.$name.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>