<?php
class dbppl{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `ppl`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `ppl`";
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
$biblio = mysql_result($r,$i,'biblio');
$predmet = mysql_result($r,$i,'predmet');
$list[]=array("id"=>$id, "biblio"=>$biblio, "predmet"=>$predmet);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `ppl` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$biblio = mysql_result($r,$i,'biblio');
$predmet = mysql_result($r,$i,'predmet');
return array("id"=>$id, "biblio"=>$biblio, "predmet"=>$predmet);
		}else{
			return false;
		}
	}
	function add($biblio, $predmet){
		$sql="INSERT INTO `ppl`(`biblio`, `predmet`) VALUES('$biblio', '$predmet')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `ppl` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $biblio, $predmet){
		$sql="UPDATE `ppl` SET ";
		$d='';if($biblio!==null){
				$sql.=$d.' `biblio`="'.$biblio.'"';
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