<?php
class registrFormAction{
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
				header('location: ?view=registrFormView');
			}
			if($password==$password2){
				$right=0;
				$dbfront_user=new dbfront_user();
				$dbfront_user->add($email, $password, $right, $login, '', '', '', date('Y-m-d H:i:s'), 0, 0, 0);
			}else{
				//некорректный пароль
				$_SESSION['registr']['error']='password error';
				header('location: ?view=registrFormView');
			}
		}
	}
}
?>