<?php
class dbprepod_plan{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `prepod_plan`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `prepod_plan`";
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
$komiss = mysql_result($r,$i,'komiss');
$god = mysql_result($r,$i,'god');
$remark = mysql_result($r,$i,'remark');
$list[]=array("id"=>$id, "prepod"=>$prepod, "komiss"=>$komiss, "god"=>$god, "remark"=>$remark);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `prepod_plan` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$prepod = mysql_result($r,$i,'prepod');
$komiss = mysql_result($r,$i,'komiss');
$god = mysql_result($r,$i,'god');
$remark = mysql_result($r,$i,'remark');
return array("id"=>$id, "prepod"=>$prepod, "komiss"=>$komiss, "god"=>$god, "remark"=>$remark);
		}else{
			return false;
		}
	}
	function add($prepod, $komiss, $god, $remark){
		$sql="INSERT INTO `prepod_plan`(`prepod`, `komiss`, `god`, `remark`) VALUES('$prepod', '$komiss', '$god', '$remark')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `prepod_plan` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $prepod, $komiss, $god, $remark){
		$sql="UPDATE `prepod_plan` SET ";
		$d='';if($prepod!==null){
				$sql.=$d.' `prepod`="'.$prepod.'"';
				$d=', ';
			}if($komiss!==null){
				$sql.=$d.' `komiss`="'.$komiss.'"';
				$d=', ';
			}if($god!==null){
				$sql.=$d.' `god`="'.$god.'"';
				$d=', ';
			}if($remark!==null){
				$sql.=$d.' `remark`="'.$remark.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>