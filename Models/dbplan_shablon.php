<?php
class dbplan_shablon{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `plan_shablon`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `plan_shablon`";
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
$razdel = mysql_result($r,$i,'razdel');
$title = mysql_result($r,$i,'title');
$shablon = mysql_result($r,$i,'shablon');
$list[]=array("id"=>$id, "razdel"=>$razdel, "title"=>$title, "shablon"=>$shablon);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `plan_shablon` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$razdel = mysql_result($r,$i,'razdel');
$title = mysql_result($r,$i,'title');
$shablon = mysql_result($r,$i,'shablon');
return array("id"=>$id, "razdel"=>$razdel, "title"=>$title, "shablon"=>$shablon);
		}else{
			return false;
		}
	}
	function add($razdel, $title, $shablon){
		$sql="INSERT INTO `plan_shablon`(`razdel`, `title`, `shablon`) VALUES('$razdel', '$title', '$shablon')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `plan_shablon` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $razdel, $title, $shablon){
		$sql="UPDATE `plan_shablon` SET ";
		$d='';if($razdel!==null){
				$sql.=$d.' `razdel`="'.$razdel.'"';
				$d=', ';
			}if($title!==null){
				$sql.=$d.' `title`="'.$title.'"';
				$d=', ';
			}if($shablon!==null){
				$sql.=$d.' `shablon`="'.$shablon.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>