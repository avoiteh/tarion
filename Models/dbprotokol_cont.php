<?php
class dbprotokol_cont{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `protokol_cont`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `protokol_cont`";
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
$preprab = mysql_result($r,$i,'preprab');
$protokol = mysql_result($r,$i,'protokol');
$list[]=array("id"=>$id, "preprab"=>$preprab, "protokol"=>$protokol);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `protokol_cont` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$preprab = mysql_result($r,$i,'preprab');
$protokol = mysql_result($r,$i,'protokol');
return array("id"=>$id, "preprab"=>$preprab, "protokol"=>$protokol);
		}else{
			return false;
		}
	}
	function add($preprab, $protokol){
		$sql="INSERT INTO `protokol_cont`(`preprab`, `protokol`) VALUES('$preprab', '$protokol')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `protokol_cont` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $preprab, $protokol){
		$sql="UPDATE `protokol_cont` SET ";
		$d='';if($preprab!==null){
				$sql.=$d.' `preprab`="'.$preprab.'"';
				$d=', ';
			}if($protokol!==null){
				$sql.=$d.' `protokol`="'.$protokol.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>