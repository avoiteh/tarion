<?php
class dbvednadbvych{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `vednadbvych`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `vednadbvych`";
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
$prepod = mysql_result($r,$i,'prepod');
$tip = mysql_result($r,$i,'tip');
$god = mysql_result($r,$i,'god');
$list[]=array("id"=>$id, "prepod"=>$prepod, "tip"=>$tip, "god"=>$god);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `vednadbvych` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$prepod = mysql_result($r,$i,'prepod');
$tip = mysql_result($r,$i,'tip');
$god = mysql_result($r,$i,'god');
return array("id"=>$id, "prepod"=>$prepod, "tip"=>$tip, "god"=>$god);
		}else{
			return false;
		}
	}
	function add($prepod, $tip, $god){
		$sql="INSERT INTO `vednadbvych`(`prepod`, `tip`, `god`) VALUES('$prepod', '$tip', '$god')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `vednadbvych` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $prepod, $tip, $god){
		$sql="UPDATE `vednadbvych` SET ";
		$d='';if($prepod!==null){
				$sql.=$d.' `prepod`="'.$prepod.'"';
				$d=', ';
			}if($tip!==null){
				$sql.=$d.' `tip`="'.$tip.'"';
				$d=', ';
			}if($god!==null){
				$sql.=$d.' `god`="'.$god.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>