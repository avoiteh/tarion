<?php
class /*table*/Model{
	function load(&$list, $where='', $order='', $start=0, $limit=''){
		$sql="SELECT * FROM /*table*/";
		if($where!=''){$sql.=" WHERE $where";}
		if($order!=''){$sql.=" ORDER BY $order";}
		if($limit!=''){$sql.=" LIMIT $start,$limit";}
		$r=mysql_query($sql);
		$i=0;
		while ($row = mysql_fetch_array($r, MYSQL_ASSOC)) {
			$list[$i]=array();
			foreach ($row as $key => $val){
				$list[$i][$key]=$val;
			}
			$i++;
		}
	}
	function getById($id){
		$sql="SELECT * FROM /*table*/ WHERE id='$id'";
		$r=mysql_query($sql);
		$record=array();
		while ($row = mysql_fetch_array($r, MYSQL_ASSOC)) {
			foreach ($row as $key => $val){
				$record[$key]=$val;
			}
		}
		return $record;
	}
	function add($record=array()){
		$names='';
		$values='';
		$d='';
		foreach ($record as $key => $val){
			$names.=$d."`$key`";
			$values.=$d."'$val'";
			$d=',';
		}
		$sql="INSERT INTO /*table*/ ($names) VALUES($values)";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM /*table*/ WHERE id='$id' LIMIT 1";
		mysql_query($sql);
	}
	function update($record=array()){
		if(isset($record['id'])){
			$sql="UPDATE /*table*/ SET ";
			$d='';
			foreach ($record as $key => $val){
				if($key!='id'){
					$sql.=$d."`$key`='$val'";
					$d=',';
				}
			}
			$sql.=" WHERE id='$record[id]' LIMIT 1";
			mysql_query($sql);
		}
	}
	function count($where=''){
		$sql="SELECT count(*) as cnt FROM /*table*/ $where";
		$r=mysql_query($sql);
		return mysql_result($r,0,'cnt');
	}
	//** tree escape block
	function loadTree($parent, $level){
		$tree=array();
		$sql="SELECT * FROM /*table*/ WHERE $/*parent*/='$parent'";
		$r=mysql_query($sql);
		$i=0;
		while ($row = mysql_fetch_array($r, MYSQL_ASSOC)) {
			$tree[$i]=array();
			foreach ($row as $key => $val){
				$tree[$i][$key]=$val;
			}
			$tree[$i]['NODE']=$this->loadTree($row['/*parent*/'], $level+1);
		}
		return $tree;
	}
	//** tree escape block
}
?>