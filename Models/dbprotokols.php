<?php
class dbprotokols{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `protokols`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `protokols`";
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
$komis = mysql_result($r,$i,'komis');
$datakomis = mysql_result($r,$i,'datakomis');
$nomer = mysql_result($r,$i,'nomer');
$status = mysql_result($r,$i,'status');
$list[]=array("id"=>$id, "komis"=>$komis, "datakomis"=>$datakomis, "nomer"=>$nomer, "status"=>$status);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `protokols` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$komis = mysql_result($r,$i,'komis');
$datakomis = mysql_result($r,$i,'datakomis');
$nomer = mysql_result($r,$i,'nomer');
$status = mysql_result($r,$i,'status');
return array("id"=>$id, "komis"=>$komis, "datakomis"=>$datakomis, "nomer"=>$nomer, "status"=>$status);
		}else{
			return false;
		}
	}
	function add($komis, $datakomis, $nomer, $status){
		$sql="INSERT INTO `protokols`(`komis`, `datakomis`, `nomer`, `status`) VALUES('$komis', '$datakomis', '$nomer', '$status')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `protokols` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $komis, $datakomis, $nomer, $status){
		$sql="UPDATE `protokols` SET ";
		$d='';if($komis!==null){
				$sql.=$d.' `komis`="'.$komis.'"';
				$d=', ';
			}if($datakomis!==null){
				$sql.=$d.' `datakomis`="'.$datakomis.'"';
				$d=', ';
			}if($nomer!==null){
				$sql.=$d.' `nomer`="'.$nomer.'"';
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