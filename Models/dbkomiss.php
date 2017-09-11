<?php
class dbkomiss{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `komiss`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `komiss`";
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
$komiss = mysql_result($r,$i,'komiss');
$predsedat = mysql_result($r,$i,'predsedat');
$status = mysql_result($r,$i,'status');
$list[]=array("id"=>$id, "komiss"=>$komiss, "predsedat"=>$predsedat, "status"=>$status);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `komiss` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$komiss = mysql_result($r,$i,'komiss');
$predsedat = mysql_result($r,$i,'predsedat');
$status = mysql_result($r,$i,'status');
return array("id"=>$id, "komiss"=>$komiss, "predsedat"=>$predsedat, "status"=>$status);
		}else{
			return false;
		}
	}
	function add($komiss, $predsedat, $status){
		$sql="INSERT INTO `komiss`(`komiss`, `predsedat`, `status`) VALUES('$komiss', '$predsedat', '$status')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `komiss` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $komiss, $predsedat, $status){
		$sql="UPDATE `komiss` SET ";
		$d='';if($komiss!==null){
				$sql.=$d.' `komiss`="'.$komiss.'"';
				$d=', ';
			}if($predsedat!==null){
				$sql.=$d.' `predsedat`="'.$predsedat.'"';
				$d=', ';
			}if($status!==null){
				$sql.=$d.' `status`="'.$status.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>