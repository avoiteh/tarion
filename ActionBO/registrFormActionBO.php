<?php
class registrFormActionBO{
	function Go(){
		if(isset($_REQUEST['login']) &&
		isset($_REQUEST['password']) &&
		isset($_REQUEST['password2']) &&
		isset($_REQUEST['email'])){
			$login=mysql_escape_string($_REQUEST['login']);
			$password=mysql_escape_string($_REQUEST['password']);
			$password2=mysql_escape_string($_REQUEST['password2']);
			$email=mysql_escape_string($_REQUEST['email']);
$_SESSION['registr']['email']=$email;
$capche=$_REQUEST['capche'];
			
			$_SESSION['registr']['login']=$login;
			if($capche!=$_SESSION['S_CAPCHE']){
				//ошибка capche
				$_SESSION['registr']['error']='capche error';
				header('location: ?view=registrFormViewBO');
			}
			if($password==$password2){
				$right=0;
				$dbuser=new dbuser();
				$dbuser->add($login, $password, $email, $right);
			}else{
				//некорректный пароль
				$_SESSION['registr']['error']='password error';
				header('location: ?view=registrFormViewBO');
			}
		}
	}
}
?>