<?php
class dbspecial{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `special`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `special`";
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
$special = mysql_result($r,$i,'special');
$topspec = mysql_result($r,$i,'topspec');
$list[]=array("id"=>$id, "special"=>$special, "topspec"=>$topspec);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `special` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$special = mysql_result($r,$i,'special');
$topspec = mysql_result($r,$i,'topspec');
return array("id"=>$id, "special"=>$special, "topspec"=>$topspec);
		}else{
			return false;
		}
	}
	function add($special, $topspec){
		$sql="INSERT INTO `special`(`special`, `topspec`) VALUES('$special', '$topspec')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `special` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $special, $topspec){
		$sql="UPDATE `special` SET ";
		$d='';if($special!==null){
				$sql.=$d.' `special`="'.$special.'"';
				$d=', ';
			}if($topspec!==null){
				$sql.=$d.' `topspec`="'.$topspec.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>