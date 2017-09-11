<?php
class dbuch_plan{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `uch_plan`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `uch_plan`";
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
$god = mysql_result($r,$i,'god');
$naim = mysql_result($r,$i,'naim');
$special = mysql_result($r,$i,'special');
$sem1 = mysql_result($r,$i,'sem1');
$sem2 = mysql_result($r,$i,'sem2');
$sem3 = mysql_result($r,$i,'sem3');
$sem4 = mysql_result($r,$i,'sem4');
$sem5 = mysql_result($r,$i,'sem5');
$sem6 = mysql_result($r,$i,'sem6');
$sem7 = mysql_result($r,$i,'sem7');
$sem8 = mysql_result($r,$i,'sem8');
$list[]=array("id"=>$id, "prepod"=>$prepod, "god"=>$god, "naim"=>$naim, "special"=>$special, "sem1"=>$sem1, "sem2"=>$sem2, "sem3"=>$sem3, "sem4"=>$sem4, "sem5"=>$sem5, "sem6"=>$sem6, "sem7"=>$sem7, "sem8"=>$sem8);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `uch_plan` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$prepod = mysql_result($r,$i,'prepod');
$god = mysql_result($r,$i,'god');
$naim = mysql_result($r,$i,'naim');
$special = mysql_result($r,$i,'special');
$sem1 = mysql_result($r,$i,'sem1');
$sem2 = mysql_result($r,$i,'sem2');
$sem3 = mysql_result($r,$i,'sem3');
$sem4 = mysql_result($r,$i,'sem4');
$sem5 = mysql_result($r,$i,'sem5');
$sem6 = mysql_result($r,$i,'sem6');
$sem7 = mysql_result($r,$i,'sem7');
$sem8 = mysql_result($r,$i,'sem8');
return array("id"=>$id, "prepod"=>$prepod, "god"=>$god, "naim"=>$naim, "special"=>$special, "sem1"=>$sem1, "sem2"=>$sem2, "sem3"=>$sem3, "sem4"=>$sem4, "sem5"=>$sem5, "sem6"=>$sem6, "sem7"=>$sem7, "sem8"=>$sem8);
		}else{
			return false;
		}
	}
	function add($prepod, $god, $naim, $special, $sem1, $sem2, $sem3, $sem4, $sem5, $sem6, $sem7, $sem8){
		$sql="INSERT INTO `uch_plan`(`prepod`, `god`, `naim`, `special`, `sem1`, `sem2`, `sem3`, `sem4`, `sem5`, `sem6`, `sem7`, `sem8`) VALUES('$prepod', '$god', '$naim', '$special', '$sem1', '$sem2', '$sem3', '$sem4', '$sem5', '$sem6', '$sem7', '$sem8')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `uch_plan` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $prepod, $god, $naim, $special, $sem1, $sem2, $sem3, $sem4, $sem5, $sem6, $sem7, $sem8){
		$sql="UPDATE `uch_plan` SET ";
		$d='';if($prepod!==null){
				$sql.=$d.' `prepod`="'.$prepod.'"';
				$d=', ';
			}if($god!==null){
				$sql.=$d.' `god`="'.$god.'"';
				$d=', ';
			}if($naim!==null){
				$sql.=$d.' `naim`="'.$naim.'"';
				$d=', ';
			}if($special!==null){
				$sql.=$d.' `special`="'.$special.'"';
				$d=', ';
			}if($sem1!==null){
				$sql.=$d.' `sem1`="'.$sem1.'"';
				$d=', ';
			}if($sem2!==null){
				$sql.=$d.' `sem2`="'.$sem2.'"';
				$d=', ';
			}if($sem3!==null){
				$sql.=$d.' `sem3`="'.$sem3.'"';
				$d=', ';
			}if($sem4!==null){
				$sql.=$d.' `sem4`="'.$sem4.'"';
				$d=', ';
			}if($sem5!==null){
				$sql.=$d.' `sem5`="'.$sem5.'"';
				$d=', ';
			}if($sem6!==null){
				$sql.=$d.' `sem6`="'.$sem6.'"';
				$d=', ';
			}if($sem7!==null){
				$sql.=$d.' `sem7`="'.$sem7.'"';
				$d=', ';
			}if($sem8!==null){
				$sql.=$d.' `sem8`="'.$sem8.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>