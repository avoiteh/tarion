<?php
class dbnov_type{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `nov_type`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `nov_type`";
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
$novtype = mysql_result($r,$i,'novtype');
$list[]=array("id"=>$id, "novtype"=>$novtype);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `nov_type` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$novtype = mysql_result($r,$i,'novtype');
return array("id"=>$id, "novtype"=>$novtype);
		}else{
			return false;
		}
	}
	function add($novtype){
		$sql="INSERT INTO `nov_type`(`novtype`) VALUES('$novtype')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `nov_type` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $novtype){
		$sql="UPDATE `nov_type` SET ";
		$d='';if($novtype!==null){
				$sql.=$d.' `novtype`="'.$novtype.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>