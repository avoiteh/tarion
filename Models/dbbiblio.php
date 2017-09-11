<?php
class dbbiblio{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `biblio`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `biblio`";
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
$booktype = mysql_result($r,$i,'booktype');
$author = mysql_result($r,$i,'author');
$title = mysql_result($r,$i,'title');
$dataizd = mysql_result($r,$i,'dataizd');
$izdatel = mysql_result($r,$i,'izdatel');
$grif = mysql_result($r,$i,'grif');
$kolvo = mysql_result($r,$i,'kolvo');
$libcat = mysql_result($r,$i,'libcat');
$list[]=array("id"=>$id, "booktype"=>$booktype, "author"=>$author, "title"=>$title, "dataizd"=>$dataizd, "izdatel"=>$izdatel, "grif"=>$grif, "kolvo"=>$kolvo, "libcat"=>$libcat);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `biblio` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$booktype = mysql_result($r,$i,'booktype');
$author = mysql_result($r,$i,'author');
$title = mysql_result($r,$i,'title');
$dataizd = mysql_result($r,$i,'dataizd');
$izdatel = mysql_result($r,$i,'izdatel');
$grif = mysql_result($r,$i,'grif');
$kolvo = mysql_result($r,$i,'kolvo');
$libcat = mysql_result($r,$i,'libcat');
return array("id"=>$id, "booktype"=>$booktype, "author"=>$author, "title"=>$title, "dataizd"=>$dataizd, "izdatel"=>$izdatel, "grif"=>$grif, "kolvo"=>$kolvo, "libcat"=>$libcat);
		}else{
			return false;
		}
	}
	function add($booktype, $author, $title, $dataizd, $izdatel, $grif, $kolvo, $libcat){
		$sql="INSERT INTO `biblio`(`booktype`, `author`, `title`, `dataizd`, `izdatel`, `grif`, `kolvo`, `libcat`) VALUES('$booktype', '$author', '$title', '$dataizd', '$izdatel', '$grif', '$kolvo', '$libcat')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `biblio` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $booktype, $author, $title, $dataizd, $izdatel, $grif, $kolvo, $libcat){
		$sql="UPDATE `biblio` SET ";
		$d='';if($booktype!==null){
				$sql.=$d.' `booktype`="'.$booktype.'"';
				$d=', ';
			}if($author!==null){
				$sql.=$d.' `author`="'.$author.'"';
				$d=', ';
			}if($title!==null){
				$sql.=$d.' `title`="'.$title.'"';
				$d=', ';
			}if($dataizd!==null){
				$sql.=$d.' `dataizd`="'.$dataizd.'"';
				$d=', ';
			}if($izdatel!==null){
				$sql.=$d.' `izdatel`="'.$izdatel.'"';
				$d=', ';
			}if($grif!==null){
				$sql.=$d.' `grif`="'.$grif.'"';
				$d=', ';
			}if($kolvo!==null){
				$sql.=$d.' `kolvo`="'.$kolvo.'"';
				$d=', ';
			}if($libcat!==null){
				$sql.=$d.' `libcat`="'.$libcat.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>