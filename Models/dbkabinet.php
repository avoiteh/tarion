<?php
class dbkabinet{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `kabinet`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `kabinet`";
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
$kabinet = mysql_result($r,$i,'kabinet');
$list[]=array("id"=>$id, "kabinet"=>$kabinet);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `kabinet` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$kabinet = mysql_result($r,$i,'kabinet');
return array("id"=>$id, "kabinet"=>$kabinet);
		}else{
			return false;
		}
	}
	function add($kabinet){
		$sql="INSERT INTO `kabinet`(`kabinet`) VALUES('$kabinet')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `kabinet` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $kabinet){
		$sql="UPDATE `kabinet` SET ";
		$d='';if($kabinet!==null){
				$sql.=$d.' `kabinet`="'.$kabinet.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>