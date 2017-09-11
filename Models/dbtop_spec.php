<?php
class dbtop_spec{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `top_spec`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `top_spec`";
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
$topspec = mysql_result($r,$i,'topspec');
$list[]=array("id"=>$id, "topspec"=>$topspec);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `top_spec` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$topspec = mysql_result($r,$i,'topspec');
return array("id"=>$id, "topspec"=>$topspec);
		}else{
			return false;
		}
	}
	function add($topspec){
		$sql="INSERT INTO `top_spec`(`topspec`) VALUES('$topspec')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `top_spec` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $topspec){
		$sql="UPDATE `top_spec` SET ";
		$d='';if($topspec!==null){
				$sql.=$d.' `topspec`="'.$topspec.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>