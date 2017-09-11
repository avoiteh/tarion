<?php
class dbreg_book{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `reg_book`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `reg_book`";
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
$datareg = mysql_result($r,$i,'datareg');
$nomer = mysql_result($r,$i,'nomer');
$naim = mysql_result($r,$i,'naim');
$prepod = mysql_result($r,$i,'prepod');
$komprot = mysql_result($r,$i,'komprot');
$komis = mysql_result($r,$i,'komis');
$status = mysql_result($r,$i,'status');
$list[]=array("id"=>$id, "datareg"=>$datareg, "nomer"=>$nomer, "naim"=>$naim, "prepod"=>$prepod, "komprot"=>$komprot, "komis"=>$komis, "status"=>$status);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `reg_book` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$datareg = mysql_result($r,$i,'datareg');
$nomer = mysql_result($r,$i,'nomer');
$naim = mysql_result($r,$i,'naim');
$prepod = mysql_result($r,$i,'prepod');
$komprot = mysql_result($r,$i,'komprot');
$komis = mysql_result($r,$i,'komis');
$status = mysql_result($r,$i,'status');
return array("id"=>$id, "datareg"=>$datareg, "nomer"=>$nomer, "naim"=>$naim, "prepod"=>$prepod, "komprot"=>$komprot, "komis"=>$komis, "status"=>$status);
		}else{
			return false;
		}
	}
	function add($datareg, $nomer, $naim, $prepod, $komprot, $komis, $status){
		$sql="INSERT INTO `reg_book`(`datareg`, `nomer`, `naim`, `prepod`, `komprot`, `komis`, `status`) VALUES('$datareg', '$nomer', '$naim', '$prepod', '$komprot', '$komis', '$status')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `reg_book` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $datareg, $nomer, $naim, $prepod, $komprot, $komis, $status){
		$sql="UPDATE `reg_book` SET ";
		$d='';if($datareg!==null){
				$sql.=$d.' `datareg`="'.$datareg.'"';
				$d=', ';
			}if($nomer!==null){
				$sql.=$d.' `nomer`="'.$nomer.'"';
				$d=', ';
			}if($naim!==null){
				$sql.=$d.' `naim`="'.$naim.'"';
				$d=', ';
			}if($prepod!==null){
				$sql.=$d.' `prepod`="'.$prepod.'"';
				$d=', ';
			}if($komprot!==null){
				$sql.=$d.' `komprot`="'.$komprot.'"';
				$d=', ';
			}if($komis!==null){
				$sql.=$d.' `komis`="'.$komis.'"';
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