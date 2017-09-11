<?php
class dbprepod_cont{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `prepod_cont`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `prepod_cont`";
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
$plann = mysql_result($r,$i,'plann');
$tip = mysql_result($r,$i,'tip');
$opis = mysql_result($r,$i,'opis');
$srok = mysql_result($r,$i,'srok');
$list[]=array("id"=>$id, "plann"=>$plann, "tip"=>$tip, "opis"=>$opis, "srok"=>$srok);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `prepod_cont` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$plann = mysql_result($r,$i,'plann');
$tip = mysql_result($r,$i,'tip');
$opis = mysql_result($r,$i,'opis');
$srok = mysql_result($r,$i,'srok');
return array("id"=>$id, "plann"=>$plann, "tip"=>$tip, "opis"=>$opis, "srok"=>$srok);
		}else{
			return false;
		}
	}
	function add($plann, $tip, $opis, $srok){
		$sql="INSERT INTO `prepod_cont`(`plann`, `tip`, `opis`, `srok`) VALUES('$plann', '$tip', '$opis', '$srok')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `prepod_cont` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $plann, $tip, $opis, $srok){
		$sql="UPDATE `prepod_cont` SET ";
		$d='';if($plann!==null){
				$sql.=$d.' `plann`="'.$plann.'"';
				$d=', ';
			}if($tip!==null){
				$sql.=$d.' `tip`="'.$tip.'"';
				$d=', ';
			}if($opis!==null){
				$sql.=$d.' `opis`="'.$opis.'"';
				$d=', ';
			}if($srok!==null){
				$sql.=$d.' `srok`="'.$srok.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>