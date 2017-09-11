<?php
class dbuch_cont{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `uch_cont`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `uch_cont`";
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
$plann = mysql_result($r,$i,'plann');
$indexplan = mysql_result($r,$i,'indexplan');
$predmet = mysql_result($r,$i,'predmet');
$theory = mysql_result($r,$i,'theory');
$praktik = mysql_result($r,$i,'praktik');
$kursov = mysql_result($r,$i,'kursov');
$samost = mysql_result($r,$i,'samost');
$kolvokontrol = mysql_result($r,$i,'kolvokontrol');
$chassem1 = mysql_result($r,$i,'chassem1');
$chassem2 = mysql_result($r,$i,'chassem2');
$chassem3 = mysql_result($r,$i,'chassem3');
$chassem4 = mysql_result($r,$i,'chassem4');
$chassem5 = mysql_result($r,$i,'chassem5');
$chassem6 = mysql_result($r,$i,'chassem6');
$chassem7 = mysql_result($r,$i,'chassem7');
$chassem8 = mysql_result($r,$i,'chassem8');
$zachsem1 = mysql_result($r,$i,'zachsem1');
$zachsem2 = mysql_result($r,$i,'zachsem2');
$zachsem3 = mysql_result($r,$i,'zachsem3');
$zachsem4 = mysql_result($r,$i,'zachsem4');
$zachsem5 = mysql_result($r,$i,'zachsem5');
$zachsem6 = mysql_result($r,$i,'zachsem6');
$zachsem7 = mysql_result($r,$i,'zachsem7');
$zachsem8 = mysql_result($r,$i,'zachsem8');
$kurssem1 = mysql_result($r,$i,'kurssem1');
$kurssem2 = mysql_result($r,$i,'kurssem2');
$kurssem3 = mysql_result($r,$i,'kurssem3');
$kurssem4 = mysql_result($r,$i,'kurssem4');
$kurssem5 = mysql_result($r,$i,'kurssem5');
$kurssem6 = mysql_result($r,$i,'kurssem6');
$kurssem7 = mysql_result($r,$i,'kurssem7');
$kurssem8 = mysql_result($r,$i,'kurssem8');
$kontrsem1 = mysql_result($r,$i,'kontrsem1');
$kontrsem2 = mysql_result($r,$i,'kontrsem2');
$kontrsem3 = mysql_result($r,$i,'kontrsem3');
$kontrsem4 = mysql_result($r,$i,'kontrsem4');
$kontrsem5 = mysql_result($r,$i,'kontrsem5');
$kontrsem6 = mysql_result($r,$i,'kontrsem6');
$kontrsem7 = mysql_result($r,$i,'kontrsem7');
$kontrsem8 = mysql_result($r,$i,'kontrsem8');
$examsem1 = mysql_result($r,$i,'examsem1');
$examsem2 = mysql_result($r,$i,'examsem2');
$examsem3 = mysql_result($r,$i,'examsem3');
$examsem4 = mysql_result($r,$i,'examsem4');
$examsem5 = mysql_result($r,$i,'examsem5');
$examsem6 = mysql_result($r,$i,'examsem6');
$examsem7 = mysql_result($r,$i,'examsem7');
$examsem8 = mysql_result($r,$i,'examsem8');
$list[]=array("id"=>$id, "plann"=>$plann, "indexplan"=>$indexplan, "predmet"=>$predmet, "theory"=>$theory, "praktik"=>$praktik, "kursov"=>$kursov, "samost"=>$samost, "kolvokontrol"=>$kolvokontrol, "chassem1"=>$chassem1, "chassem2"=>$chassem2, "chassem3"=>$chassem3, "chassem4"=>$chassem4, "chassem5"=>$chassem5, "chassem6"=>$chassem6, "chassem7"=>$chassem7, "chassem8"=>$chassem8, "zachsem1"=>$zachsem1, "zachsem2"=>$zachsem2, "zachsem3"=>$zachsem3, "zachsem4"=>$zachsem4, "zachsem5"=>$zachsem5, "zachsem6"=>$zachsem6, "zachsem7"=>$zachsem7, "zachsem8"=>$zachsem8, "kurssem1"=>$kurssem1, "kurssem2"=>$kurssem2, "kurssem3"=>$kurssem3, "kurssem4"=>$kurssem4, "kurssem5"=>$kurssem5, "kurssem6"=>$kurssem6, "kurssem7"=>$kurssem7, "kurssem8"=>$kurssem8, "kontrsem1"=>$kontrsem1, "kontrsem2"=>$kontrsem2, "kontrsem3"=>$kontrsem3, "kontrsem4"=>$kontrsem4, "kontrsem5"=>$kontrsem5, "kontrsem6"=>$kontrsem6, "kontrsem7"=>$kontrsem7, "kontrsem8"=>$kontrsem8, "examsem1"=>$examsem1, "examsem2"=>$examsem2, "examsem3"=>$examsem3, "examsem4"=>$examsem4, "examsem5"=>$examsem5, "examsem6"=>$examsem6, "examsem7"=>$examsem7, "examsem8"=>$examsem8);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `uch_cont` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$plann = mysql_result($r,$i,'plann');
$indexplan = mysql_result($r,$i,'indexplan');
$predmet = mysql_result($r,$i,'predmet');
$theory = mysql_result($r,$i,'theory');
$praktik = mysql_result($r,$i,'praktik');
$kursov = mysql_result($r,$i,'kursov');
$samost = mysql_result($r,$i,'samost');
$kolvokontrol = mysql_result($r,$i,'kolvokontrol');
$chassem1 = mysql_result($r,$i,'chassem1');
$chassem2 = mysql_result($r,$i,'chassem2');
$chassem3 = mysql_result($r,$i,'chassem3');
$chassem4 = mysql_result($r,$i,'chassem4');
$chassem5 = mysql_result($r,$i,'chassem5');
$chassem6 = mysql_result($r,$i,'chassem6');
$chassem7 = mysql_result($r,$i,'chassem7');
$chassem8 = mysql_result($r,$i,'chassem8');
$zachsem1 = mysql_result($r,$i,'zachsem1');
$zachsem2 = mysql_result($r,$i,'zachsem2');
$zachsem3 = mysql_result($r,$i,'zachsem3');
$zachsem4 = mysql_result($r,$i,'zachsem4');
$zachsem5 = mysql_result($r,$i,'zachsem5');
$zachsem6 = mysql_result($r,$i,'zachsem6');
$zachsem7 = mysql_result($r,$i,'zachsem7');
$zachsem8 = mysql_result($r,$i,'zachsem8');
$kurssem1 = mysql_result($r,$i,'kurssem1');
$kurssem2 = mysql_result($r,$i,'kurssem2');
$kurssem3 = mysql_result($r,$i,'kurssem3');
$kurssem4 = mysql_result($r,$i,'kurssem4');
$kurssem5 = mysql_result($r,$i,'kurssem5');
$kurssem6 = mysql_result($r,$i,'kurssem6');
$kurssem7 = mysql_result($r,$i,'kurssem7');
$kurssem8 = mysql_result($r,$i,'kurssem8');
$kontrsem1 = mysql_result($r,$i,'kontrsem1');
$kontrsem2 = mysql_result($r,$i,'kontrsem2');
$kontrsem3 = mysql_result($r,$i,'kontrsem3');
$kontrsem4 = mysql_result($r,$i,'kontrsem4');
$kontrsem5 = mysql_result($r,$i,'kontrsem5');
$kontrsem6 = mysql_result($r,$i,'kontrsem6');
$kontrsem7 = mysql_result($r,$i,'kontrsem7');
$kontrsem8 = mysql_result($r,$i,'kontrsem8');
$examsem1 = mysql_result($r,$i,'examsem1');
$examsem2 = mysql_result($r,$i,'examsem2');
$examsem3 = mysql_result($r,$i,'examsem3');
$examsem4 = mysql_result($r,$i,'examsem4');
$examsem5 = mysql_result($r,$i,'examsem5');
$examsem6 = mysql_result($r,$i,'examsem6');
$examsem7 = mysql_result($r,$i,'examsem7');
$examsem8 = mysql_result($r,$i,'examsem8');
return array("id"=>$id, "plann"=>$plann, "indexplan"=>$indexplan, "predmet"=>$predmet, "theory"=>$theory, "praktik"=>$praktik, "kursov"=>$kursov, "samost"=>$samost, "kolvokontrol"=>$kolvokontrol, "chassem1"=>$chassem1, "chassem2"=>$chassem2, "chassem3"=>$chassem3, "chassem4"=>$chassem4, "chassem5"=>$chassem5, "chassem6"=>$chassem6, "chassem7"=>$chassem7, "chassem8"=>$chassem8, "zachsem1"=>$zachsem1, "zachsem2"=>$zachsem2, "zachsem3"=>$zachsem3, "zachsem4"=>$zachsem4, "zachsem5"=>$zachsem5, "zachsem6"=>$zachsem6, "zachsem7"=>$zachsem7, "zachsem8"=>$zachsem8, "kurssem1"=>$kurssem1, "kurssem2"=>$kurssem2, "kurssem3"=>$kurssem3, "kurssem4"=>$kurssem4, "kurssem5"=>$kurssem5, "kurssem6"=>$kurssem6, "kurssem7"=>$kurssem7, "kurssem8"=>$kurssem8, "kontrsem1"=>$kontrsem1, "kontrsem2"=>$kontrsem2, "kontrsem3"=>$kontrsem3, "kontrsem4"=>$kontrsem4, "kontrsem5"=>$kontrsem5, "kontrsem6"=>$kontrsem6, "kontrsem7"=>$kontrsem7, "kontrsem8"=>$kontrsem8, "examsem1"=>$examsem1, "examsem2"=>$examsem2, "examsem3"=>$examsem3, "examsem4"=>$examsem4, "examsem5"=>$examsem5, "examsem6"=>$examsem6, "examsem7"=>$examsem7, "examsem8"=>$examsem8);
		}else{
			return false;
		}
	}
	function add($plann, $indexplan, $predmet, $theory, $praktik, $kursov, $samost, $kolvokontrol, $chassem1, $chassem2, $chassem3, $chassem4, $chassem5, $chassem6, $chassem7, $chassem8, $zachsem1, $zachsem2, $zachsem3, $zachsem4, $zachsem5, $zachsem6, $zachsem7, $zachsem8, $kurssem1, $kurssem2, $kurssem3, $kurssem4, $kurssem5, $kurssem6, $kurssem7, $kurssem8, $kontrsem1, $kontrsem2, $kontrsem3, $kontrsem4, $kontrsem5, $kontrsem6, $kontrsem7, $kontrsem8, $examsem1, $examsem2, $examsem3, $examsem4, $examsem5, $examsem6, $examsem7, $examsem8){
		$sql="INSERT INTO `uch_cont`(`plann`, `indexplan`, `predmet`, `theory`, `praktik`, `kursov`, `samost`, `kolvokontrol`, `chassem1`, `chassem2`, `chassem3`, `chassem4`, `chassem5`, `chassem6`, `chassem7`, `chassem8`, `zachsem1`, `zachsem2`, `zachsem3`, `zachsem4`, `zachsem5`, `zachsem6`, `zachsem7`, `zachsem8`, `kurssem1`, `kurssem2`, `kurssem3`, `kurssem4`, `kurssem5`, `kurssem6`, `kurssem7`, `kurssem8`, `kontrsem1`, `kontrsem2`, `kontrsem3`, `kontrsem4`, `kontrsem5`, `kontrsem6`, `kontrsem7`, `kontrsem8`, `examsem1`, `examsem2`, `examsem3`, `examsem4`, `examsem5`, `examsem6`, `examsem7`, `examsem8`) VALUES('$plann', '$indexplan', '$predmet', '$theory', '$praktik', '$kursov', '$samost', '$kolvokontrol', '$chassem1', '$chassem2', '$chassem3', '$chassem4', '$chassem5', '$chassem6', '$chassem7', '$chassem8', '$zachsem1', '$zachsem2', '$zachsem3', '$zachsem4', '$zachsem5', '$zachsem6', '$zachsem7', '$zachsem8', '$kurssem1', '$kurssem2', '$kurssem3', '$kurssem4', '$kurssem5', '$kurssem6', '$kurssem7', '$kurssem8', '$kontrsem1', '$kontrsem2', '$kontrsem3', '$kontrsem4', '$kontrsem5', '$kontrsem6', '$kontrsem7', '$kontrsem8', '$examsem1', '$examsem2', '$examsem3', '$examsem4', '$examsem5', '$examsem6', '$examsem7', '$examsem8')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `uch_cont` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $plann, $indexplan, $predmet, $theory, $praktik, $kursov, $samost, $kolvokontrol, $chassem1, $chassem2, $chassem3, $chassem4, $chassem5, $chassem6, $chassem7, $chassem8, $zachsem1, $zachsem2, $zachsem3, $zachsem4, $zachsem5, $zachsem6, $zachsem7, $zachsem8, $kurssem1, $kurssem2, $kurssem3, $kurssem4, $kurssem5, $kurssem6, $kurssem7, $kurssem8, $kontrsem1, $kontrsem2, $kontrsem3, $kontrsem4, $kontrsem5, $kontrsem6, $kontrsem7, $kontrsem8, $examsem1, $examsem2, $examsem3, $examsem4, $examsem5, $examsem6, $examsem7, $examsem8){
		$sql="UPDATE `uch_cont` SET ";
		$d='';if($plann!==null){
				$sql.=$d.' `plann`="'.$plann.'"';
				$d=', ';
			}if($indexplan!==null){
				$sql.=$d.' `indexplan`="'.$indexplan.'"';
				$d=', ';
			}if($predmet!==null){
				$sql.=$d.' `predmet`="'.$predmet.'"';
				$d=', ';
			}if($theory!==null){
				$sql.=$d.' `theory`="'.$theory.'"';
				$d=', ';
			}if($praktik!==null){
				$sql.=$d.' `praktik`="'.$praktik.'"';
				$d=', ';
			}if($kursov!==null){
				$sql.=$d.' `kursov`="'.$kursov.'"';
				$d=', ';
			}if($samost!==null){
				$sql.=$d.' `samost`="'.$samost.'"';
				$d=', ';
			}if($kolvokontrol!==null){
				$sql.=$d.' `kolvokontrol`="'.$kolvokontrol.'"';
				$d=', ';
			}if($chassem1!==null){
				$sql.=$d.' `chassem1`="'.$chassem1.'"';
				$d=', ';
			}if($chassem2!==null){
				$sql.=$d.' `chassem2`="'.$chassem2.'"';
				$d=', ';
			}if($chassem3!==null){
				$sql.=$d.' `chassem3`="'.$chassem3.'"';
				$d=', ';
			}if($chassem4!==null){
				$sql.=$d.' `chassem4`="'.$chassem4.'"';
				$d=', ';
			}if($chassem5!==null){
				$sql.=$d.' `chassem5`="'.$chassem5.'"';
				$d=', ';
			}if($chassem6!==null){
				$sql.=$d.' `chassem6`="'.$chassem6.'"';
				$d=', ';
			}if($chassem7!==null){
				$sql.=$d.' `chassem7`="'.$chassem7.'"';
				$d=', ';
			}if($chassem8!==null){
				$sql.=$d.' `chassem8`="'.$chassem8.'"';
				$d=', ';
			}if($zachsem1!==null){
				$sql.=$d.' `zachsem1`="'.$zachsem1.'"';
				$d=', ';
			}if($zachsem2!==null){
				$sql.=$d.' `zachsem2`="'.$zachsem2.'"';
				$d=', ';
			}if($zachsem3!==null){
				$sql.=$d.' `zachsem3`="'.$zachsem3.'"';
				$d=', ';
			}if($zachsem4!==null){
				$sql.=$d.' `zachsem4`="'.$zachsem4.'"';
				$d=', ';
			}if($zachsem5!==null){
				$sql.=$d.' `zachsem5`="'.$zachsem5.'"';
				$d=', ';
			}if($zachsem6!==null){
				$sql.=$d.' `zachsem6`="'.$zachsem6.'"';
				$d=', ';
			}if($zachsem7!==null){
				$sql.=$d.' `zachsem7`="'.$zachsem7.'"';
				$d=', ';
			}if($zachsem8!==null){
				$sql.=$d.' `zachsem8`="'.$zachsem8.'"';
				$d=', ';
			}if($kurssem1!==null){
				$sql.=$d.' `kurssem1`="'.$kurssem1.'"';
				$d=', ';
			}if($kurssem2!==null){
				$sql.=$d.' `kurssem2`="'.$kurssem2.'"';
				$d=', ';
			}if($kurssem3!==null){
				$sql.=$d.' `kurssem3`="'.$kurssem3.'"';
				$d=', ';
			}if($kurssem4!==null){
				$sql.=$d.' `kurssem4`="'.$kurssem4.'"';
				$d=', ';
			}if($kurssem5!==null){
				$sql.=$d.' `kurssem5`="'.$kurssem5.'"';
				$d=', ';
			}if($kurssem6!==null){
				$sql.=$d.' `kurssem6`="'.$kurssem6.'"';
				$d=', ';
			}if($kurssem7!==null){
				$sql.=$d.' `kurssem7`="'.$kurssem7.'"';
				$d=', ';
			}if($kurssem8!==null){
				$sql.=$d.' `kurssem8`="'.$kurssem8.'"';
				$d=', ';
			}if($kontrsem1!==null){
				$sql.=$d.' `kontrsem1`="'.$kontrsem1.'"';
				$d=', ';
			}if($kontrsem2!==null){
				$sql.=$d.' `kontrsem2`="'.$kontrsem2.'"';
				$d=', ';
			}if($kontrsem3!==null){
				$sql.=$d.' `kontrsem3`="'.$kontrsem3.'"';
				$d=', ';
			}if($kontrsem4!==null){
				$sql.=$d.' `kontrsem4`="'.$kontrsem4.'"';
				$d=', ';
			}if($kontrsem5!==null){
				$sql.=$d.' `kontrsem5`="'.$kontrsem5.'"';
				$d=', ';
			}if($kontrsem6!==null){
				$sql.=$d.' `kontrsem6`="'.$kontrsem6.'"';
				$d=', ';
			}if($kontrsem7!==null){
				$sql.=$d.' `kontrsem7`="'.$kontrsem7.'"';
				$d=', ';
			}if($kontrsem8!==null){
				$sql.=$d.' `kontrsem8`="'.$kontrsem8.'"';
				$d=', ';
			}if($examsem1!==null){
				$sql.=$d.' `examsem1`="'.$examsem1.'"';
				$d=', ';
			}if($examsem2!==null){
				$sql.=$d.' `examsem2`="'.$examsem2.'"';
				$d=', ';
			}if($examsem3!==null){
				$sql.=$d.' `examsem3`="'.$examsem3.'"';
				$d=', ';
			}if($examsem4!==null){
				$sql.=$d.' `examsem4`="'.$examsem4.'"';
				$d=', ';
			}if($examsem5!==null){
				$sql.=$d.' `examsem5`="'.$examsem5.'"';
				$d=', ';
			}if($examsem6!==null){
				$sql.=$d.' `examsem6`="'.$examsem6.'"';
				$d=', ';
			}if($examsem7!==null){
				$sql.=$d.' `examsem7`="'.$examsem7.'"';
				$d=', ';
			}if($examsem8!==null){
				$sql.=$d.' `examsem8`="'.$examsem8.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>