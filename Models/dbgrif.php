<?php
class dbgrif{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `grif`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `grif`";
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
$grif = mysql_result($r,$i,'grif');
$list[]=array("id"=>$id, "grif"=>$grif);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `grif` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$grif = mysql_result($r,$i,'grif');
return array("id"=>$id, "grif"=>$grif);
		}else{
			return false;
		}
	}
	function add($grif){
		$sql="INSERT INTO `grif`(`grif`) VALUES('$grif')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `grif` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $grif){
		$sql="UPDATE `grif` SET ";
		$d='';if($grif!==null){
				$sql.=$d.' `grif`="'.$grif.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>