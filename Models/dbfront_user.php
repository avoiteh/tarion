<?php
class dbfront_user{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `front_user`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `front_user`";
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
$email = mysql_result($r,$i,'email');
$password = mysql_result($r,$i,'password');
$right = mysql_result($r,$i,'right');
$login = mysql_result($r,$i,'login');
$family = mysql_result($r,$i,'family');
$name = mysql_result($r,$i,'name');
$otch = mysql_result($r,$i,'otch');
$dataworkstart = mysql_result($r,$i,'dataworkstart');
$razryd = mysql_result($r,$i,'razryd');
$category = mysql_result($r,$i,'category');
$kabinet = mysql_result($r,$i,'kabinet');
$list[]=array("id"=>$id, "email"=>$email, "password"=>$password, "right"=>$right, "login"=>$login, "family"=>$family, "name"=>$name, "otch"=>$otch, "dataworkstart"=>$dataworkstart, "razryd"=>$razryd, "category"=>$category, "kabinet"=>$kabinet);
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `front_user` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
$email = mysql_result($r,$i,'email');
$password = mysql_result($r,$i,'password');
$right = mysql_result($r,$i,'right');
$login = mysql_result($r,$i,'login');
$family = mysql_result($r,$i,'family');
$name = mysql_result($r,$i,'name');
$otch = mysql_result($r,$i,'otch');
$dataworkstart = mysql_result($r,$i,'dataworkstart');
$razryd = mysql_result($r,$i,'razryd');
$category = mysql_result($r,$i,'category');
$kabinet = mysql_result($r,$i,'kabinet');
return array("id"=>$id, "email"=>$email, "password"=>$password, "right"=>$right, "login"=>$login, "family"=>$family, "name"=>$name, "otch"=>$otch, "dataworkstart"=>$dataworkstart, "razryd"=>$razryd, "category"=>$category, "kabinet"=>$kabinet);
		}else{
			return false;
		}
	}
	function add($email, $password, $right, $login, $family, $name, $otch, $dataworkstart, $razryd, $category, $kabinet){
		$sql="INSERT INTO `front_user`(`email`, `password`, `right`, `login`, `family`, `name`, `otch`, `dataworkstart`, `razryd`, `category`, `kabinet`) VALUES('$email', '$password', '$right', '$login', '$family', '$name', '$otch', '$dataworkstart', '$razryd', '$category', '$kabinet')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `front_user` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id, $email, $password, $right, $login, $family, $name, $otch, $dataworkstart, $razryd, $category, $kabinet){
		$sql="UPDATE `front_user` SET ";
		$d='';if($email!==null){
				$sql.=$d.' `email`="'.$email.'"';
				$d=', ';
			}if($password!==null){
				$sql.=$d.' `password`="'.$password.'"';
				$d=', ';
			}if($right!==null){
				$sql.=$d.' `right`="'.$right.'"';
				$d=', ';
			}if($login!==null){
				$sql.=$d.' `login`="'.$login.'"';
				$d=', ';
			}if($family!==null){
				$sql.=$d.' `family`="'.$family.'"';
				$d=', ';
			}if($name!==null){
				$sql.=$d.' `name`="'.$name.'"';
				$d=', ';
			}if($otch!==null){
				$sql.=$d.' `otch`="'.$otch.'"';
				$d=', ';
			}if($dataworkstart!==null){
				$sql.=$d.' `dataworkstart`="'.$dataworkstart.'"';
				$d=', ';
			}if($razryd!==null){
				$sql.=$d.' `razryd`="'.$razryd.'"';
				$d=', ';
			}if($category!==null){
				$sql.=$d.' `category`="'.$category.'"';
				$d=', ';
			}if($kabinet!==null){
				$sql.=$d.' `kabinet`="'.$kabinet.'"';
				$d=', ';
			}
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}
?>