<?php
class dbuser{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `user`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `user`";
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
$login = mysql_result($r,$i,'login');
$password = mysql_result($r,$i,'password');
$email = mysql_result($r,$i,'email');
$right = mysql_result($r,$i,'right');
$list[]=array("id"=>$id, "login"=>$login, "password"=>$password, "email"=>$email, "right"=>$right);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `user` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$login = mysql_result($r,$i,'login');
$password = mysql_result($r,$i,'password');
$email = mysql_result($r,$i,'email');
$right = mysql_result($r,$i,'right');
return array("id"=>$id, "login"=>$login, "password"=>$password, "email"=>$email, "right"=>$right);
		}else{
			return false;
		}
	}
	function add($login, $password, $email, $right){
		$sql="INSERT INTO `user`(`login`, `password`, `email`, `right`) VALUES('$login', '$password', '$email', '$right')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `user` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $login, $password, $email, $right){
		$sql="UPDATE `user` SET ";
		$d='';if($login!==null){
				$sql.=$d.' `login`="'.$login.'"';
				$d=', ';
			}if($password!==null){
				$sql.=$d.' `password`="'.$password.'"';
				$d=', ';
			}if($email!==null){
				$sql.=$d.' `email`="'.$email.'"';
				$d=', ';
			}if($right!==null){
				$sql.=$d.' `right`="'.$right.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>