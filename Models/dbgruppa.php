<?php
class dbgruppa{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `gruppa`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `gruppa`";
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
$gruppa = mysql_result($r,$i,'gruppa');
$special = mysql_result($r,$i,'special');
$kurs = mysql_result($r,$i,'kurs');
$sozdan = mysql_result($r,$i,'sozdan');
$status = mysql_result($r,$i,'status');
$list[]=array("id"=>$id, "gruppa"=>$gruppa, "special"=>$special, "kurs"=>$kurs, "sozdan"=>$sozdan, "status"=>$status);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `gruppa` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$gruppa = mysql_result($r,$i,'gruppa');
$special = mysql_result($r,$i,'special');
$kurs = mysql_result($r,$i,'kurs');
$sozdan = mysql_result($r,$i,'sozdan');
$status = mysql_result($r,$i,'status');
return array("id"=>$id, "gruppa"=>$gruppa, "special"=>$special, "kurs"=>$kurs, "sozdan"=>$sozdan, "status"=>$status);
		}else{
			return false;
		}
	}
	function add($gruppa, $special, $kurs, $sozdan, $status){
		$sql="INSERT INTO `gruppa`(`gruppa`, `special`, `kurs`, `sozdan`, `status`) VALUES('$gruppa', '$special', '$kurs', '$sozdan', '$status')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `gruppa` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $gruppa, $special, $kurs, $sozdan, $status){
		$sql="UPDATE `gruppa` SET ";
		$d='';if($gruppa!==null){
				$sql.=$d.' `gruppa`="'.$gruppa.'"';
				$d=', ';
			}if($special!==null){
				$sql.=$d.' `special`="'.$special.'"';
				$d=', ';
			}if($kurs!==null){
				$sql.=$d.' `kurs`="'.$kurs.'"';
				$d=', ';
			}if($sozdan!==null){
				$sql.=$d.' `sozdan`="'.$sozdan.'"';
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