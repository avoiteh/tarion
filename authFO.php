<?php
function checkAuthFO($user_id, $module_name){
	//ищем такого юзера
	$sql="SELECT * FROM front_user WHERE id=".($user_id*1);
	$r=mysql_query($sql);
	$n=mysql_num_rows($r);
	if($n>0){
		//ищем такой модуль
		$right=mysql_result($r,0,'right');
	}elseif ($user_id==0){
		$right=0;
	}else{
		return false;
	}
	$sql="SELECT * FROM front_modules WHERE module='$module_name'";
	$r=mysql_query($sql);
	$n=mysql_num_rows($r);
	if($n>0){
		$module=mysql_result($r,0,'id');
		//ищем такой модуль с правами такого юзера
		$sql="SELECT count(*) as cnt FROM front_cross_right WHERE (`right`=$right OR `right`=0) AND module=$module";
		$r=mysql_query($sql);
		$cnt=mysql_result($r,0,'cnt');
		if($cnt>0){
			//можно этот модуль этому юзеру
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
function loginFO($login, $password){
	$sql="SELECT * FROM front_user WHERE login='".mysql_escape_string($login)."' AND password='".mysql_escape_string($password)."'";
	$r=mysql_query($sql);
	$n=mysql_num_rows($r);
	if($n>0){
		$_SESSION['front_user_id']=mysql_result($r,0,'id');
	}
}
function logOutFO(){
	unset($_SESSION['front_user_id']);
}
?>