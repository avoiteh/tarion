<?php
class dbblok{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `blok`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `blok`";
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
$sortindex = mysql_result($r,$i,'sortindex');
$list[]=array("id"=>$id, "blok"=>$blok, "sortindex"=>$sortindex);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `blok` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$blok = mysql_result($r,$i,'blok');
$sortindex = mysql_result($r,$i,'sortindex');
return array("id"=>$id, "blok"=>$blok, "sortindex"=>$sortindex);
		}else{
			return false;
		}
	}
	function add($blok, $sortindex){
		$sql="INSERT INTO `blok`(`blok`, `sortindex`) VALUES('$blok', '$sortindex')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `blok` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $blok, $sortindex){
		$sql="UPDATE `blok` SET ";
		$d='';if($blok!==null){
				$sql.=$d.' `blok`="'.$blok.'"';
				$d=', ';
			}if($sortindex!==null){
				$sql.=$d.' `sortindex`="'.$sortindex.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>