<?php
class dbsostav_komis{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `sostav_komis`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `sostav_komis`";
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
$komis = mysql_result($r,$i,'komis');
$prepod = mysql_result($r,$i,'prepod');
$status = mysql_result($r,$i,'status');
$list[]=array("id"=>$id, "komis"=>$komis, "prepod"=>$prepod, "status"=>$status);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `sostav_komis` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$komis = mysql_result($r,$i,'komis');
$prepod = mysql_result($r,$i,'prepod');
$status = mysql_result($r,$i,'status');
return array("id"=>$id, "komis"=>$komis, "prepod"=>$prepod, "status"=>$status);
		}else{
			return false;
		}
	}
	function add($komis, $prepod, $status){
		$sql="INSERT INTO `sostav_komis`(`komis`, `prepod`, `status`) VALUES('$komis', '$prepod', '$status')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `sostav_komis` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $komis, $prepod, $status){
		$sql="UPDATE `sostav_komis` SET ";
		$d='';if($komis!==null){
				$sql.=$d.' `komis`="'.$komis.'"';
				$d=', ';
			}if($prepod!==null){
				$sql.=$d.' `prepod`="'.$prepod.'"';
				$d=', ';
			}if($status!==null){
				$sql.=$d.' `status`="'.$status.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>