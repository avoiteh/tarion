<?php
class dbnadbvych{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `nadbvych`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `nadbvych`";
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
$naim = mysql_result($r,$i,'naim');
$formula = mysql_result($r,$i,'formula');
$list[]=array("id"=>$id, "naim"=>$naim, "formula"=>$formula);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `nadbvych` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$naim = mysql_result($r,$i,'naim');
$formula = mysql_result($r,$i,'formula');
return array("id"=>$id, "naim"=>$naim, "formula"=>$formula);
		}else{
			return false;
		}
	}
	function add($naim, $formula){
		$sql="INSERT INTO `nadbvych`(`naim`, `formula`) VALUES('$naim', '$formula')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `nadbvych` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $naim, $formula){
		$sql="UPDATE `nadbvych` SET ";
		$d='';if($naim!==null){
				$sql.=$d.' `naim`="'.$naim.'"';
				$d=', ';
			}if($formula!==null){
				$sql.=$d.' `formula`="'.$formula.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>