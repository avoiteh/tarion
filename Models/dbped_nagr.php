<?php
class dbped_nagr{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `ped_nagr`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `ped_nagr`";
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
$god = mysql_result($r,$i,'god');
$prepod = mysql_result($r,$i,'prepod');
$predmet = mysql_result($r,$i,'predmet');
$gruppa = mysql_result($r,$i,'gruppa');
$theory = mysql_result($r,$i,'theory');
$praktik = mysql_result($r,$i,'praktik');
$kurs = mysql_result($r,$i,'kurs');
$kurstest = mysql_result($r,$i,'kurstest');
$examine = mysql_result($r,$i,'examine');
$allhour = mysql_result($r,$i,'allhour');
$sem1chas = mysql_result($r,$i,'sem1chas');
$sem1ned = mysql_result($r,$i,'sem1ned');
$sem2chas = mysql_result($r,$i,'sem2chas');
$sem2ned = mysql_result($r,$i,'sem2ned');
$sem1vych = mysql_result($r,$i,'sem1vych');
$sem2vych = mysql_result($r,$i,'sem2vych');
$prikaz = mysql_result($r,$i,'prikaz');
$remark = mysql_result($r,$i,'remark');
$list[]=array("id"=>$id, "god"=>$god, "prepod"=>$prepod, "predmet"=>$predmet, "gruppa"=>$gruppa, "theory"=>$theory, "praktik"=>$praktik, "kurs"=>$kurs, "kurstest"=>$kurstest, "examine"=>$examine, "allhour"=>$allhour, "sem1chas"=>$sem1chas, "sem1ned"=>$sem1ned, "sem2chas"=>$sem2chas, "sem2ned"=>$sem2ned, "sem1vych"=>$sem1vych, "sem2vych"=>$sem2vych, "prikaz"=>$prikaz, "remark"=>$remark);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `ped_nagr` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$god = mysql_result($r,$i,'god');
$prepod = mysql_result($r,$i,'prepod');
$predmet = mysql_result($r,$i,'predmet');
$gruppa = mysql_result($r,$i,'gruppa');
$theory = mysql_result($r,$i,'theory');
$praktik = mysql_result($r,$i,'praktik');
$kurs = mysql_result($r,$i,'kurs');
$kurstest = mysql_result($r,$i,'kurstest');
$examine = mysql_result($r,$i,'examine');
$allhour = mysql_result($r,$i,'allhour');
$sem1chas = mysql_result($r,$i,'sem1chas');
$sem1ned = mysql_result($r,$i,'sem1ned');
$sem2chas = mysql_result($r,$i,'sem2chas');
$sem2ned = mysql_result($r,$i,'sem2ned');
$sem1vych = mysql_result($r,$i,'sem1vych');
$sem2vych = mysql_result($r,$i,'sem2vych');
$prikaz = mysql_result($r,$i,'prikaz');
$remark = mysql_result($r,$i,'remark');
return array("id"=>$id, "god"=>$god, "prepod"=>$prepod, "predmet"=>$predmet, "gruppa"=>$gruppa, "theory"=>$theory, "praktik"=>$praktik, "kurs"=>$kurs, "kurstest"=>$kurstest, "examine"=>$examine, "allhour"=>$allhour, "sem1chas"=>$sem1chas, "sem1ned"=>$sem1ned, "sem2chas"=>$sem2chas, "sem2ned"=>$sem2ned, "sem1vych"=>$sem1vych, "sem2vych"=>$sem2vych, "prikaz"=>$prikaz, "remark"=>$remark);
		}else{
			return false;
		}
	}
	function add($god, $prepod, $predmet, $gruppa, $theory, $praktik, $kurs, $kurstest, $examine, $allhour, $sem1chas, $sem1ned, $sem2chas, $sem2ned, $sem1vych, $sem2vych, $prikaz, $remark){
		$sql="INSERT INTO `ped_nagr`(`god`, `prepod`, `predmet`, `gruppa`, `theory`, `praktik`, `kurs`, `kurstest`, `examine`, `allhour`, `sem1chas`, `sem1ned`, `sem2chas`, `sem2ned`, `sem1vych`, `sem2vych`, `prikaz`, `remark`) VALUES('$god', '$prepod', '$predmet', '$gruppa', '$theory', '$praktik', '$kurs', '$kurstest', '$examine', '$allhour', '$sem1chas', '$sem1ned', '$sem2chas', '$sem2ned', '$sem1vych', '$sem2vych', '$prikaz', '$remark')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `ped_nagr` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $god, $prepod, $predmet, $gruppa, $theory, $praktik, $kurs, $kurstest, $examine, $allhour, $sem1chas, $sem1ned, $sem2chas, $sem2ned, $sem1vych, $sem2vych, $prikaz, $remark){
		$sql="UPDATE `ped_nagr` SET ";
		$d='';if($god!==null){
				$sql.=$d.' `god`="'.$god.'"';
				$d=', ';
			}if($prepod!==null){
				$sql.=$d.' `prepod`="'.$prepod.'"';
				$d=', ';
			}if($predmet!==null){
				$sql.=$d.' `predmet`="'.$predmet.'"';
				$d=', ';
			}if($gruppa!==null){
				$sql.=$d.' `gruppa`="'.$gruppa.'"';
				$d=', ';
			}if($theory!==null){
				$sql.=$d.' `theory`="'.$theory.'"';
				$d=', ';
			}if($praktik!==null){
				$sql.=$d.' `praktik`="'.$praktik.'"';
				$d=', ';
			}if($kurs!==null){
				$sql.=$d.' `kurs`="'.$kurs.'"';
				$d=', ';
			}if($kurstest!==null){
				$sql.=$d.' `kurstest`="'.$kurstest.'"';
				$d=', ';
			}if($examine!==null){
				$sql.=$d.' `examine`="'.$examine.'"';
				$d=', ';
			}if($allhour!==null){
				$sql.=$d.' `allhour`="'.$allhour.'"';
				$d=', ';
			}if($sem1chas!==null){
				$sql.=$d.' `sem1chas`="'.$sem1chas.'"';
				$d=', ';
			}if($sem1ned!==null){
				$sql.=$d.' `sem1ned`="'.$sem1ned.'"';
				$d=', ';
			}if($sem2chas!==null){
				$sql.=$d.' `sem2chas`="'.$sem2chas.'"';
				$d=', ';
			}if($sem2ned!==null){
				$sql.=$d.' `sem2ned`="'.$sem2ned.'"';
				$d=', ';
			}if($sem1vych!==null){
				$sql.=$d.' `sem1vych`="'.$sem1vych.'"';
				$d=', ';
			}if($sem2vych!==null){
				$sql.=$d.' `sem2vych`="'.$sem2vych.'"';
				$d=', ';
			}if($prikaz!==null){
				$sql.=$d.' `prikaz`="'.$prikaz.'"';
				$d=', ';
			}if($remark!==null){
				$sql.=$d.' `remark`="'.$remark.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>