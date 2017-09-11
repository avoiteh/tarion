<?php
class dblibcat{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `libcat`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `libcat`";
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
$libcat = mysql_result($r,$i,'libcat');
$list[]=array("id"=>$id, "libcat"=>$libcat);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `libcat` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$libcat = mysql_result($r,$i,'libcat');
return array("id"=>$id, "libcat"=>$libcat);
		}else{
			return false;
		}
	}
	function add($libcat){
		$sql="INSERT INTO `libcat`(`libcat`) VALUES('$libcat')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `libcat` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $libcat){
		$sql="UPDATE `libcat` SET ";
		$d='';if($libcat!==null){
				$sql.=$d.' `libcat`="'.$libcat.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>