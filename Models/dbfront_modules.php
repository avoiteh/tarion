<?php
class dbfront_modules{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `front_modules`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `front_modules`";
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
$module = mysql_result($r,$i,'module');
$parent = mysql_result($r,$i,'parent');
$title = mysql_result($r,$i,'title');
$type = mysql_result($r,$i,'type');
$list[]=array("id"=>$id, "module"=>$module, "parent"=>$parent, "title"=>$title, "type"=>$type);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `front_modules` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$module = mysql_result($r,$i,'module');
$parent = mysql_result($r,$i,'parent');
$title = mysql_result($r,$i,'title');
$type = mysql_result($r,$i,'type');
return array("id"=>$id, "module"=>$module, "parent"=>$parent, "title"=>$title, "type"=>$type);
		}else{
			return false;
		}
	}
	function add($module, $parent, $title, $type){
		$sql="INSERT INTO `front_modules`(`module`, `parent`, `title`, `type`) VALUES('$module', '$parent', '$title', '$type')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `front_modules` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $module, $parent, $title, $type){
		$sql="UPDATE `front_modules` SET ";
		$d='';if($module!==null){
				$sql.=$d.' `module`="'.$module.'"';
				$d=', ';
			}if($parent!==null){
				$sql.=$d.' `parent`="'.$parent.'"';
				$d=', ';
			}if($title!==null){
				$sql.=$d.' `title`="'.$title.'"';
				$d=', ';
			}if($type!==null){
				$sql.=$d.' `type`="'.$type.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>