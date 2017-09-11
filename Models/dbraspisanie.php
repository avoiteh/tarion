<?php
class dbraspisanie{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `raspisanie`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `raspisanie`";
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
$week = mysql_result($r,$i,'week');
$predmet = mysql_result($r,$i,'predmet');
$gruppa = mysql_result($r,$i,'gruppa');
$prepod = mysql_result($r,$i,'prepod');
$den = mysql_result($r,$i,'den');
$para = mysql_result($r,$i,'para');
$kabinet = mysql_result($r,$i,'kabinet');
$year = mysql_result($r,$i,'year');
$list[]=array("id"=>$id, "week"=>$week, "predmet"=>$predmet, "gruppa"=>$gruppa, "prepod"=>$prepod, "den"=>$den, "para"=>$para, "kabinet"=>$kabinet, "year"=>$year);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `raspisanie` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$week = mysql_result($r,$i,'week');
$predmet = mysql_result($r,$i,'predmet');
$gruppa = mysql_result($r,$i,'gruppa');
$prepod = mysql_result($r,$i,'prepod');
$den = mysql_result($r,$i,'den');
$para = mysql_result($r,$i,'para');
$kabinet = mysql_result($r,$i,'kabinet');
$year = mysql_result($r,$i,'year');
return array("id"=>$id, "week"=>$week, "predmet"=>$predmet, "gruppa"=>$gruppa, "prepod"=>$prepod, "den"=>$den, "para"=>$para, "kabinet"=>$kabinet, "year"=>$year);
		}else{
			return false;
		}
	}
	function add($week, $predmet, $gruppa, $prepod, $den, $para, $kabinet, $year){
		$sql="INSERT INTO `raspisanie`(`week`, `predmet`, `gruppa`, `prepod`, `den`, `para`, `kabinet`, `year`) VALUES('$week', '$predmet', '$gruppa', '$prepod', '$den', '$para', '$kabinet', '$year')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `raspisanie` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $week, $predmet, $gruppa, $prepod, $den, $para, $kabinet, $year){
		$sql="UPDATE `raspisanie` SET ";
		$d='';if($week!==null){
				$sql.=$d.' `week`="'.$week.'"';
				$d=', ';
			}if($predmet!==null){
				$sql.=$d.' `predmet`="'.$predmet.'"';
				$d=', ';
			}if($gruppa!==null){
				$sql.=$d.' `gruppa`="'.$gruppa.'"';
				$d=', ';
			}if($prepod!==null){
				$sql.=$d.' `prepod`="'.$prepod.'"';
				$d=', ';
			}if($den!==null){
				$sql.=$d.' `den`="'.$den.'"';
				$d=', ';
			}if($para!==null){
				$sql.=$d.' `para`="'.$para.'"';
				$d=', ';
			}if($kabinet!==null){
				$sql.=$d.' `kabinet`="'.$kabinet.'"';
				$d=', ';
			}if($year!==null){
				$sql.=$d.' `year`="'.$year.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>