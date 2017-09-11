<?php
class dbppr{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `ppr`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `ppr`";
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
$list[]=array("id"=>$id, "razdel"=>$razdel);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `ppr` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$razdel = mysql_result($r,$i,'razdel');
return array("id"=>$id, "razdel"=>$razdel);
		}else{
			return false;
		}
	}
	function add($razdel){
		$sql="INSERT INTO `ppr`(`razdel`) VALUES('$razdel')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `ppr` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $razdel){
		$sql="UPDATE `ppr` SET ";
		$d='';if($razdel!==null){
				$sql.=$d.' `razdel`="'.$razdel.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>