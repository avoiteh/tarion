<?php
class dbpredmet{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `predmet`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `predmet`";
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
$blok = mysql_result($r,$i,'blok');
$predmet = mysql_result($r,$i,'predmet');
$list[]=array("id"=>$id, "blok"=>$blok, "predmet"=>$predmet);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `predmet` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$blok = mysql_result($r,$i,'blok');
$predmet = mysql_result($r,$i,'predmet');
return array("id"=>$id, "blok"=>$blok, "predmet"=>$predmet);
		}else{
			return false;
		}
	}
	function add($blok, $predmet){
		$sql="INSERT INTO `predmet`(`blok`, `predmet`) VALUES('$blok', '$predmet')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `predmet` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $blok, $predmet){
		$sql="UPDATE `predmet` SET ";
		$d='';if($blok!==null){
				$sql.=$d.' `blok`="'.$blok.'"';
				$d=', ';
			}if($predmet!==null){
				$sql.=$d.' `predmet`="'.$predmet.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>