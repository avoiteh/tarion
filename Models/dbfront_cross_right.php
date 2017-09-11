<?php
class dbfront_cross_right{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `front_cross_right`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `front_cross_right`";
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
$right = mysql_result($r,$i,'right');
$list[]=array("id"=>$id, "module"=>$module, "right"=>$right);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `front_cross_right` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$module = mysql_result($r,$i,'module');
$right = mysql_result($r,$i,'right');
return array("id"=>$id, "module"=>$module, "right"=>$right);
		}else{
			return false;
		}
	}
	function add($module, $right){
		$sql="INSERT INTO `front_cross_right`(`module`, `right`) VALUES('$module', '$right')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function delByModuleRight($module, $right){
		$sql="DELETE FROM `front_cross_right` WHERE `module`=$module AND `right`=$right";
		mysql_query($sql);
	}
	function del($id){
		$sql="DELETE FROM `front_cross_right` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $module, $right){
		$sql="UPDATE `front_cross_right` SET ";
		$d='';if($module!=null){
				$sql.=$d.' `module`="'.$module.'"';
				$d=', ';
			}if($right!=null){
				$sql.=$d.' `right`="'.$right.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>