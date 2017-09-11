<?php
class dbuchenik{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `uchenik`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `uchenik`";
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
$family = mysql_result($r,$i,'family');
$name = mysql_result($r,$i,'name');
$otch = mysql_result($r,$i,'otch');
$gruppa = mysql_result($r,$i,'gruppa');
$kurszach = mysql_result($r,$i,'kurszach');
$datarozhd = mysql_result($r,$i,'datarozhd');
$mesto = mysql_result($r,$i,'mesto');
$adres = mysql_result($r,$i,'adres');
$nation = mysql_result($r,$i,'nation');
$zachprikaz = mysql_result($r,$i,'zachprikaz');
$zachdata = mysql_result($r,$i,'zachdata');
$obrazovanie = mysql_result($r,$i,'obrazovanie');
$perevod2prikaz = mysql_result($r,$i,'perevod2prikaz');
$perevod2data = mysql_result($r,$i,'perevod2data');
$perevod3prikaz = mysql_result($r,$i,'perevod3prikaz');
$perevod3data = mysql_result($r,$i,'perevod3data');
$perevod4prikaz = mysql_result($r,$i,'perevod4prikaz');
$perevod4data = mysql_result($r,$i,'perevod4data');
$perevod5prikaz = mysql_result($r,$i,'perevod5prikaz');
$perevod5data = mysql_result($r,$i,'perevod5data');
$vypuskprikaz = mysql_result($r,$i,'vypuskprikaz');
$vypuskdata = mysql_result($r,$i,'vypuskdata');
$father = mysql_result($r,$i,'father');
$mother = mysql_result($r,$i,'mother');
$parents = mysql_result($r,$i,'parents');
$status = mysql_result($r,$i,'status');
$phone = mysql_result($r,$i,'phone');
$list[]=array("id"=>$id, "family"=>$family, "name"=>$name, "otch"=>$otch, "gruppa"=>$gruppa, "kurszach"=>$kurszach, "datarozhd"=>$datarozhd, "mesto"=>$mesto, "adres"=>$adres, "nation"=>$nation, "zachprikaz"=>$zachprikaz, "zachdata"=>$zachdata, "obrazovanie"=>$obrazovanie, "perevod2prikaz"=>$perevod2prikaz, "perevod2data"=>$perevod2data, "perevod3prikaz"=>$perevod3prikaz, "perevod3data"=>$perevod3data, "perevod4prikaz"=>$perevod4prikaz, "perevod4data"=>$perevod4data, "perevod5prikaz"=>$perevod5prikaz, "perevod5data"=>$perevod5data, "vypuskprikaz"=>$vypuskprikaz, "vypuskdata"=>$vypuskdata, "father"=>$father, "mother"=>$mother, "parents"=>$parents, "status"=>$status, "phone"=>$phone);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `uchenik` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$family = mysql_result($r,$i,'family');
$name = mysql_result($r,$i,'name');
$otch = mysql_result($r,$i,'otch');
$gruppa = mysql_result($r,$i,'gruppa');
$kurszach = mysql_result($r,$i,'kurszach');
$datarozhd = mysql_result($r,$i,'datarozhd');
$mesto = mysql_result($r,$i,'mesto');
$adres = mysql_result($r,$i,'adres');
$nation = mysql_result($r,$i,'nation');
$zachprikaz = mysql_result($r,$i,'zachprikaz');
$zachdata = mysql_result($r,$i,'zachdata');
$obrazovanie = mysql_result($r,$i,'obrazovanie');
$perevod2prikaz = mysql_result($r,$i,'perevod2prikaz');
$perevod2data = mysql_result($r,$i,'perevod2data');
$perevod3prikaz = mysql_result($r,$i,'perevod3prikaz');
$perevod3data = mysql_result($r,$i,'perevod3data');
$perevod4prikaz = mysql_result($r,$i,'perevod4prikaz');
$perevod4data = mysql_result($r,$i,'perevod4data');
$perevod5prikaz = mysql_result($r,$i,'perevod5prikaz');
$perevod5data = mysql_result($r,$i,'perevod5data');
$vypuskprikaz = mysql_result($r,$i,'vypuskprikaz');
$vypuskdata = mysql_result($r,$i,'vypuskdata');
$father = mysql_result($r,$i,'father');
$mother = mysql_result($r,$i,'mother');
$parents = mysql_result($r,$i,'parents');
$status = mysql_result($r,$i,'status');
$phone = mysql_result($r,$i,'phone');
return array("id"=>$id, "family"=>$family, "name"=>$name, "otch"=>$otch, "gruppa"=>$gruppa, "kurszach"=>$kurszach, "datarozhd"=>$datarozhd, "mesto"=>$mesto, "adres"=>$adres, "nation"=>$nation, "zachprikaz"=>$zachprikaz, "zachdata"=>$zachdata, "obrazovanie"=>$obrazovanie, "perevod2prikaz"=>$perevod2prikaz, "perevod2data"=>$perevod2data, "perevod3prikaz"=>$perevod3prikaz, "perevod3data"=>$perevod3data, "perevod4prikaz"=>$perevod4prikaz, "perevod4data"=>$perevod4data, "perevod5prikaz"=>$perevod5prikaz, "perevod5data"=>$perevod5data, "vypuskprikaz"=>$vypuskprikaz, "vypuskdata"=>$vypuskdata, "father"=>$father, "mother"=>$mother, "parents"=>$parents, "status"=>$status, "phone"=>$phone);
		}else{
			return false;
		}
	}
	function add($family, $name, $otch, $gruppa, $kurszach, $datarozhd, $mesto, $adres, $nation, $zachprikaz, $zachdata, $obrazovanie, $perevod2prikaz, $perevod2data, $perevod3prikaz, $perevod3data, $perevod4prikaz, $perevod4data, $perevod5prikaz, $perevod5data, $vypuskprikaz, $vypuskdata, $father, $mother, $parents, $status, $phone){
		$sql="INSERT INTO `uchenik`(`family`, `name`, `otch`, `gruppa`, `kurszach`, `datarozhd`, `mesto`, `adres`, `nation`, `zachprikaz`, `zachdata`, `obrazovanie`, `perevod2prikaz`, `perevod2data`, `perevod3prikaz`, `perevod3data`, `perevod4prikaz`, `perevod4data`, `perevod5prikaz`, `perevod5data`, `vypuskprikaz`, `vypuskdata`, `father`, `mother`, `parents`, `status`, `phone`) VALUES('$family', '$name', '$otch', '$gruppa', '$kurszach', '$datarozhd', '$mesto', '$adres', '$nation', '$zachprikaz', '$zachdata', '$obrazovanie', '$perevod2prikaz', '$perevod2data', '$perevod3prikaz', '$perevod3data', '$perevod4prikaz', '$perevod4data', '$perevod5prikaz', '$perevod5data', '$vypuskprikaz', '$vypuskdata', '$father', '$mother', '$parents', '$status', '$phone')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `uchenik` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $family, $name, $otch, $gruppa, $kurszach, $datarozhd, $mesto, $adres, $nation, $zachprikaz, $zachdata, $obrazovanie, $perevod2prikaz, $perevod2data, $perevod3prikaz, $perevod3data, $perevod4prikaz, $perevod4data, $perevod5prikaz, $perevod5data, $vypuskprikaz, $vypuskdata, $father, $mother, $parents, $status, $phone){
		$sql="UPDATE `uchenik` SET ";
		$d='';if($family!==null){
				$sql.=$d.' `family`="'.$family.'"';
				$d=', ';
			}if($name!==null){
				$sql.=$d.' `name`="'.$name.'"';
				$d=', ';
			}if($otch!==null){
				$sql.=$d.' `otch`="'.$otch.'"';
				$d=', ';
			}if($gruppa!==null){
				$sql.=$d.' `gruppa`="'.$gruppa.'"';
				$d=', ';
			}if($kurszach!==null){
				$sql.=$d.' `kurszach`="'.$kurszach.'"';
				$d=', ';
			}if($datarozhd!==null){
				$sql.=$d.' `datarozhd`="'.$datarozhd.'"';
				$d=', ';
			}if($mesto!==null){
				$sql.=$d.' `mesto`="'.$mesto.'"';
				$d=', ';
			}if($adres!==null){
				$sql.=$d.' `adres`="'.$adres.'"';
				$d=', ';
			}if($nation!==null){
				$sql.=$d.' `nation`="'.$nation.'"';
				$d=', ';
			}if($zachprikaz!==null){
				$sql.=$d.' `zachprikaz`="'.$zachprikaz.'"';
				$d=', ';
			}if($zachdata!==null){
				$sql.=$d.' `zachdata`="'.$zachdata.'"';
				$d=', ';
			}if($obrazovanie!==null){
				$sql.=$d.' `obrazovanie`="'.$obrazovanie.'"';
				$d=', ';
			}if($perevod2prikaz!==null){
				$sql.=$d.' `perevod2prikaz`="'.$perevod2prikaz.'"';
				$d=', ';
			}if($perevod2data!==null){
				$sql.=$d.' `perevod2data`="'.$perevod2data.'"';
				$d=', ';
			}if($perevod3prikaz!==null){
				$sql.=$d.' `perevod3prikaz`="'.$perevod3prikaz.'"';
				$d=', ';
			}if($perevod3data!==null){
				$sql.=$d.' `perevod3data`="'.$perevod3data.'"';
				$d=', ';
			}if($perevod4prikaz!==null){
				$sql.=$d.' `perevod4prikaz`="'.$perevod4prikaz.'"';
				$d=', ';
			}if($perevod4data!==null){
				$sql.=$d.' `perevod4data`="'.$perevod4data.'"';
				$d=', ';
			}if($perevod5prikaz!==null){
				$sql.=$d.' `perevod5prikaz`="'.$perevod5prikaz.'"';
				$d=', ';
			}if($perevod5data!==null){
				$sql.=$d.' `perevod5data`="'.$perevod5data.'"';
				$d=', ';
			}if($vypuskprikaz!==null){
				$sql.=$d.' `vypuskprikaz`="'.$vypuskprikaz.'"';
				$d=', ';
			}if($vypuskdata!==null){
				$sql.=$d.' `vypuskdata`="'.$vypuskdata.'"';
				$d=', ';
			}if($father!==null){
				$sql.=$d.' `father`="'.$father.'"';
				$d=', ';
			}if($mother!==null){
				$sql.=$d.' `mother`="'.$mother.'"';
				$d=', ';
			}if($parents!==null){
				$sql.=$d.' `parents`="'.$parents.'"';
				$d=', ';
			}if($status!==null){
				$sql.=$d.' `status`="'.$status.'"';
				$d=', ';
			}if($phone!==null){
				$sql.=$d.' `phone`="'.$phone.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>