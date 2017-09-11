<?php
session_start();

//проверить наличие конфигурацции
if(isset($_SESSION['CFG'])){
	$CFG=$_SESSION['CFG'];
}else{
	//отобразить бланк конфигурации
	if(file_exists('tarion.cfg')){
		$CFG=unserialize(file_get_contents('tarion.cfg'));
		$_SESSION['CFG']=$CFG;
	}
	if(!is_array($CFG)){
		$CFG=array(
		"dbhost"=>"localhost",
		"dblogin"=>"root",
		"dbpassword"=>"",
		"database"=>"tarion"
		);
		file_put_contents('tarion.cfg', serialize($CFG));
	}
}

if(isset($_GET['form_flag']) && $_GET['form_flag']=='cfg'){
	foreach ($_POST as $key=>$val) {
		$CFG[$key]=$val;
	}
	file_put_contents('tarion.cfg', serialize($CFG));
}
?>
<html>
<head>
<title>Tarion</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
Конфигурация&nbsp;&nbsp;|&nbsp;&nbsp;<a href="main.php">Главная панель</a><br>
<form action="?form_flag=cfg" method="POST">
<table border="1">
<tr>
	<td>Имя</td>
	<td>Поле</td>
</tr>
<?php
foreach ($CFG as $key=>$val){
	?><tr>
	<td><?=$key?></td>
	<td><input type="text" name="<?=$key?>" value="<?=$val?>"></td>
</tr><?php
}
?>
<tr>
	<td colspan="2"><input type="submit" value=" Save "></td>
</tr>
</table>
</form>
</body>
</html>