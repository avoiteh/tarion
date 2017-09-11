<?php
function makeAddCRUDclassFO($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class add".$viewName."Action{
	function Go(){
		\$db$mainTable[name]=new db$mainTable[name]();
";
		
		//если есть какие-то фильтры, то надо указывать данные из этих фильтров
		foreach ($mainTable['fields'] as $field_name => $field){
			$s.="if(\$_SESSION['$viewName']['filter_check']['$field_name']=='on'){
	\$$field_name=\$_SESSION['$viewName']['filter']['$field_name'];
}else{
	\$$field_name=";
			if($field['type']=='string' || $field['type']=='text'){
				$s.="''";
			}else{
				$s.='0';
			}
			$s.=";
}
";
			if($crud['type']=='TreeCRUD'){
				if($field_name==$crud['content']['parent_key']){
					$s.="\$$field_name=mysql_escape_string(\$$field_name);
";
				}
			}
		}
		if($crud['type']=='TreeCRUD'){
		$s.="\$".$crud['content']['parent_key']."=\$_REQUEST['".$crud['content']['parent_key']."'];
";
	}
		
		$s.="\$db$mainTable[name]->add(";
		$d='';
		foreach ($mainTable['fields'] as $field_name => $field){
			$s.=$d." \$$field_name";
			/*
			if($crud['type']=='TreeCRUD'){
				if($field['type']=='string' || $field['type']=='text'){
					if($field_name==$crud['content']['parent_key']){
						$s.="mysql_escape_string(\$$field_name)";
					}else{
						$s.="''";
					}
				}else{
					if($field_name==$crud['content']['parent_key']){
						$s.="\$$field_name*1";
					}else{
						$s.="0";
					}
				}
			}else{
				if($field['type']=='string' || $field['type']=='text'){
					$s.="''";
				}else{
					$s.="0";
				}
			}*/
			$d=', ';
		}
		$s.=");
	}
}
?>";
	return $s;
}
?><?php
function makeAddCRUDclass($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class add".$viewName."ActionBO{
	function Go(){
		\$db$mainTable[name]=new db$mainTable[name]();
";
	
		//если есть какие-то фильтры, то надо указывать данные из этих фильтров
		foreach ($mainTable['fields'] as $field_name => $field){
			$s.="if(\$_SESSION['$viewName']['filter_check']['$field_name']=='on'){
	\$$field_name=\$_SESSION['$viewName']['filter']['$field_name'];
}else{
	\$$field_name=";
			if($field['type']=='string' || $field['type']=='text'){
				$s.="''";
			}else{
				$s.='0';
			}
			$s.=";
}
";
			if($crud['type']=='TreeCRUD'){
				if($field_name==$crud['content']['parent_key']){
					$s.="\$$field_name=mysql_escape_string(\$$field_name);
";
				}
			}
		}
		
		if($crud['type']=='TreeCRUD'){
		$s.="\$".$crud['content']['parent_key']."=\$_REQUEST['".$crud['content']['parent_key']."'];
";
	}

		$s.="\$db$mainTable[name]->add(";
		$d='';
		foreach ($mainTable['fields'] as $field_name => $field){
			$s.=$d." \$$field_name";
			/*
			if($crud['type']=='TreeCRUD'){
				if($field['type']=='string' || $field['type']=='text'){
					if($field_name==$crud['content']['parent_key']){
						$s.="mysql_escape_string(\$$field_name)";
					}else{
						$s.="''";
					}
				}else{
					if($field_name==$crud['content']['parent_key']){
						$s.="\$$field_name*1";
					}else{
						$s.="0";
					}
				}
			}else{
				if($field['type']=='string' || $field['type']=='text'){
					$s.="''";
					
					
					
				}else{
					$s.="0";
				}
			}
			*/
			$d=', ';
		}
		$s.=");
	}
}
?>";
	return $s;
}
?><?php
function makeDelCRUDclassFO($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class del".$viewName."Action{
	function Go(){
		\$db$mainTable[name]=new db$mainTable[name]();
		\$db$mainTable[name]->del(\$_REQUEST['id']*1);
	}
}
?>";
	return $s;
}
?><?php
function makeDelCRUDclass($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class del".$viewName."ActionBO{
	function Go(){
		\$db$mainTable[name]=new db$mainTable[name]();
		\$db$mainTable[name]->del(\$_REQUEST['id']*1);
	}
}
?>";
	return $s;
}
?><?php
function makeActionRegistrBO($tables){
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	$s="<?php
class registrFormActionBO{
	function Go(){
		if(isset(\$_REQUEST['login']) &&
		isset(\$_REQUEST['password']) &&
		isset(\$_REQUEST['password2']) &&
		isset(\$_REQUEST['email'])){
			\$login=mysql_escape_string(\$_REQUEST['login']);
			\$password=mysql_escape_string(\$_REQUEST['password']);
			\$password2=mysql_escape_string(\$_REQUEST['password2']);
			";
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){		
	$s.="\$$fname=mysql_escape_string(\$_REQUEST['$fname']);
\$_SESSION['registr']['$fname']=\$$fname;
";
		}
	}
		$s.="\$capche=\$_REQUEST['capche'];
			
			\$_SESSION['registr']['login']=\$login;
			if(\$capche!=\$_SESSION['S_CAPCHE']){
				//ошибка capche
				\$_SESSION['registr']['error']='capche error';
				header('location: ?view=registrFormViewBO');
			}
			if(\$password==\$password2){
				\$right=0;
				\$dbuser=new dbuser();
				\$dbuser->add(";
		$d='';
		foreach ($table['fields'] as $fname => $field){
			$s.=$d.'$'.$fname;
			$d=', ';
		}
		$s.=");
			}else{
				//некорректный пароль
				\$_SESSION['registr']['error']='password error';
				header('location: ?view=registrFormViewBO');
			}
		}
	}
}
?>";
	return $s;
}
?><?php
function makeActionRegistrFO($tables){
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	$s="<?php
class registrFormAction{
	function Go(){
		if(isset(\$_REQUEST['login']) &&
		isset(\$_REQUEST['password']) &&
		isset(\$_REQUEST['password2']) &&
		isset(\$_REQUEST['email'])){
			\$login=mysql_escape_string(\$_REQUEST['login']);
			\$password=mysql_escape_string(\$_REQUEST['password']);
			\$password2=mysql_escape_string(\$_REQUEST['password2']);
			";
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){		
	$s.="\$$fname=mysql_escape_string(\$_REQUEST['$fname']);
\$_SESSION['registr']['$fname']=\$$fname;
";
		}
	}
		$s.="\$capche=\$_REQUEST['capche'];
			
			\$_SESSION['registr']['login']=\$login;
			if(\$capche!=\$_SESSION['S_CAPCHE']){
				//ошибка capche
				\$_SESSION['registr']['error']='capche error';
				header('location: ?view=registrFormView');
			}
			if(\$password==\$password2){
				\$right=0;
				\$dbfront_user=new dbfront_user();
				\$dbfront_user->add(\$email, \$password, \$right, \$login, '', '', '', date('Y-m-d H:i:s'), 0, 0, 0);
			}else{
				//некорректный пароль
				\$_SESSION['registr']['error']='password error';
				header('location: ?view=registrFormView');
			}
		}
	}
}
?>";
	return $s;
}
?><?php
function makeUpdateCRUDclassFO($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class update".$viewName."Action{
	function Go(){
		\$id=\$_REQUEST['id']*1;
		\$db$mainTable[name]=new db$mainTable[name]();
		//новые поля
		";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$type=$mainTable['fields'][$fname]['type'];
			if($type=='file'){
				$s.="if(isset(\$_FILES['$fname']) && \$_FILES['$fname']['tmp_name']!=''){
			\$path=photoPath(\$id).'/$fname';
			copy(\$_FILES['$fname']['tmp_name'], \$path);
		}";
			}
		}
	}
		$s.="
		\$db$mainTable[name]->update(\$id";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$type=$mainTable['fields'][$fname]['type'];
			switch ($type){
				case 'int':
				case 'on_off':
					$s.=", (\$_REQUEST['$fname']*1)";
				break;
				case 'string':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'date':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'text':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'file':
					$s.=", \$id";
				break;
			}
		}else{
			if($fname!='ID'){
				$s.=", null";
			}
		}
	}
		$s.=");
	}
}
?>";
	return $s;
}
?><?php
function makeUpdateCRUDclass($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class update".$viewName."ActionBO{
	function Go(){
		\$id=\$_REQUEST['id']*1;
		\$db$mainTable[name]=new db$mainTable[name]();
		//новые поля
		";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$type=$mainTable['fields'][$fname]['type'];
			if($type=='file'){
				$s.="if(isset(\$_FILES['$fname']) && \$_FILES['$fname']['tmp_name']!=''){
			\$path=photoPath(\$id).'/$fname';
			copy(\$_FILES['$fname']['tmp_name'], \$path);
		}";
			}
		}
	}
		$s.="
		\$db$mainTable[name]->update(\$id";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$type=$mainTable['fields'][$fname]['type'];
			switch ($type){
				case 'int':
				case 'on_off':
					$s.=", (\$_REQUEST['$fname']*1)";
				break;
				case 'string':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'date':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'text':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'file':
					$s.=", \$id";
				break;
			}
		}else{
			if($fname!='ID'){
				$s.=", null";
			}
		}
	}
		$s.=");
	}
}
?>";
	return $s;
}
?><?php
function checkAuthBO($user_id, $module_name){
	//ищем такого юзера
	$sql="SELECT * FROM user WHERE id=".($user_id*1);
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
	$sql="SELECT * FROM modules WHERE module='$module_name'";
	$r=mysql_query($sql);
	$n=mysql_num_rows($r);
	if($n>0){
		$module=mysql_result($r,0,'id');
		//ищем такой модуль с правами такого юзера
		$sql="SELECT count(*) as cnt FROM cross_right WHERE (`right`=$right OR `right`=0) AND module=$module";
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

function loginBO($login, $password){
	$sql="SELECT * FROM user WHERE login='".mysql_escape_string($login)."' AND password='".mysql_escape_string($password)."'";
	$r=mysql_query($sql);
	$n=mysql_num_rows($r);
	if($n>0){
		$_SESSION['user_id']=mysql_result($r,0,'id');
	}
}
function logOutBO(){
	unset($_SESSION['user_id']);
}
?><?php
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
?><?php
session_start();
require_once('connect_db.php');
require_once('authBO.php');
require_once('lib.php');
requireDir('Models/');
requireDir('ViewBO/');
requireDir('ActionBO/');

//проверяем попытку авторизации
if(isset($_REQUEST['login']) && isset($_REQUEST['password'])){
	loginBO($_REQUEST['login'], $_REQUEST['password']);
}

$menu = new menuBO();

if(isset($_REQUEST['action'])){
	//проверит авторизацию
	if(checkAuthBO($_SESSION['user_id'], $_REQUEST['action'])){
		eval("\$action=new $_REQUEST[action]();");
		$action->Go();
	}
}
if(isset($_REQUEST['view'])){
	//проверит авторизацию
	if(checkAuthBO($_SESSION['user_id'], $_REQUEST['view'])){
		eval("\$view=new $_REQUEST[view]();");
	}
}else{
	$view=null;
}
?>
<html>
<head>
<title>Tarion</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="tbl_change.js"></script>
<?php $menu->Paint();?>
<td align="right">
<input type="button" onclick="document.getElementById('authTable').style.display='block';" value="Авторизация">
</td>
</tr>
</table>
<table id='authTable' style="position:absolute;top:300px;left:300px;width:150px;background-color:Aqua;display:none;">
<form method="POST" action="">
<tr><td>login:</td><td><input type="text" name="login" style="width:80px;height:18px;"></td></tr>
<tr><td>password:</td><td><input type="password" name="password" style="width:80px;height:18px;"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Вход" style="height:18px;"></td></tr>
<tr><td colspan="2" align="center"><a href="?view=registrFormView">Регистрация</a></td></tr>
</form>
</table>
<script>
document.getElementById('authTable').style.left=Math.round(document.body.clientWidth/2 - 150/2);
</script>

<br>
<table width="100%" border="1">
<tr></tr>
	<td valign="top"><?php if($view!=null){$view->Paint();}?></td>
</tr>
</table>
</body>
</html><html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Календарь</title>
	<meta name="robots" content="noindex,nofollow" />
</head>
<body>
<style>
/* general tags */
html {
    font-size: 82%;
}

input, select, textarea {
    font-size: 1em;
}

body {
    font-family:        sans-serif;
    padding:            0;
    margin:             0.5em;
    color:              #000000;
    background:         #F5F5F5;
}

textarea, tt, pre, code {
    font-family:        monospace;
}
h1 {
    font-size:          140%;
    font-weight:        bold;
}

h2 {
    font-size:          120%;
    font-weight:        bold;
}

h3 {
    font-weight:        bold;
}

a:link,
a:visited,
a:active {
    text-decoration:    none;
    color:              #0000FF;
}

a:hover {
    text-decoration:    underline;
    color:              #FF0000;
}

dfn {
    font-style:         normal;
}

dfn:hover {
    font-style:         normal;
    cursor:             help;
}

th {
    font-weight:        bold;
    color:              #000000;
    background:         #D3DCE3;
}

a img {
    border:             0;
}

hr {
    color:              #000000;
    background-color:   #000000;
    border:             0;
    height:             1px;
}

form {
    padding:            0;
    margin:             0;
    display:            inline;
}

textarea {
    overflow:           visible;
    height:             9em;
}

fieldset {
    margin-top:         1em;
    border:             #000000 solid 1px;
    padding:            0.5em;
    background:         #E5E5E5;
}

fieldset fieldset {
    margin:             0.8em;
}

fieldset legend {
    font-weight:        bold;
    color:              #444444;
    background-color:   transparent;
}

/* buttons in some browsers (eg. Konqueror) are block elements,
   this breaks design */
button {
    display:            inline;
}

table caption,
table th,
table td {
    padding:            0.1em 0.5em 0.1em 0.5em;
    margin:             0.1em;
    vertical-align:     top;
}

img,
input,
select,
button {
    vertical-align:     middle;
}
/* Calendar */
table.calendar {
    width:              100%;
}
table.calendar td {
    text-align:         center;
}
table.calendar td a {
    display:            block;
}

table.calendar td a:hover {
    background-color:   #CCFFCC;
}

table.calendar th {
    background-color:   #D3DCE3;
}

table.calendar td.selected {
    background-color:   #FFCC99;
}

img.calendar {
    border:             none;
}
form.clock {
    text-align:         center;
}
/* end Calendar */
</style>
<script src="tbl_change.js"></script>
<script>
var month_names = new Array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
var day_names = new Array("Пн","Вт","Ср","Чт","Пт","Сб","Вс");
var submit_text = " Время ";
</script>
</head>
<body onload="initCalendar();">
<div id="calendar_data"></div>
<div id="clock_data"></div>
</body>
</html>
<?php
session_start();
Header("Content-type: image/gif");


$capche_img=imagecreate(100,20);

$white = ImageColorAllocate($capche_img, 255,255,255);
$black = ImageColorAllocate($capche_img, 0,0,0);


$r=imagefilledrectangle($capche_img, 0, 0, 70, 20, $white); 
$smb = '0987654321abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
if(!isset($_SESSION['S_CAPCHE'])){session_register('S_CAPCHE');}
$_SESSION['S_CAPCHE']='';
for($i=0;$i<7;$i++){
	$_SESSION['S_CAPCHE'].=$smb[rand(0,strlen($smb)-1)];
}
$pos = array(0,1,2,3,4,5);
$x=2;
for($i=0;$i<strlen($_SESSION['S_CAPCHE']);$i++){
	$s=$_SESSION['S_CAPCHE'][$i];
	$y=$pos[rand(0,5)];
	$r=imagestring($capche_img, 5, $x, $y, $s, $black);
	$x+=9;
}
$r=imagegif($capche_img); 
?><?php
class menuBO{
	var $menuTree;
	function Paint(){
		$this->menuTree=unserialize('/*menu*/');
		$this->TreePaint(0,0);
	}
	function TreePaint($parent,$level){
		$i=0;
		$j=0;
		$node=array();
		foreach($this->menuTree as $i => $punkt){
			if($punkt['parent']==$parent){
				$node[$j]=$punkt;
				$j++;
			}
		}
		$max=$j-1;
		foreach($node as $i => $punkt){
			if($punkt['type']=='menu'){
				if($max>0){
					?><li class='Node ExpandLeaf'><?php
				}else{
					?>"<li class='Node ExpandLeaf IsLast'><?php
				}
				$max--;
				?><div class='Expand'></div>
				<div class='Content' style='cursor:pointer;'>
				<?php
				/*
				меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
				*/
				$next=$this->checkCRUDByParent($i);
				if($next===false){
					echo $punkt['name'];
				}else{
					$link=translit($this->menuTree[$next]['name']);
					?><a href="/<?php echo $link;?>"><?php echo $punkt['name'];?></a><?php
				}
				?>
				</div>
				<ul class='Container'><?php echo $this->TreePaint($i,$level+1);?>
				</ul>
				</li><?php
			}else{
				
			}
		}
	}
	function checkCRUDByParent($parent){
		//если находится CRUD или TreeCRUD, то вернуть id элемента, иначе вернуть false
		$result=false;
		foreach ($this->menuTree as $id => $element){
			if($element['type']=='CRUD' || $element['type']=='TreeCRUD'){
				$result=$id;
			}
		}
		return $result;
	}
	function getImgByType($type){
		switch($type){
			case 'menu':
				return 'menu.gif';
			break;
			case 'CRUD':
				return 'crud.gif';
			break;
			case 'TreeCRUD':
				return 'tree_crud.gif';
			break;
		}
	}
}
?><?php
class menuBO{
	var $menuTree;
	function Paint(){
		$this->menuTree=unserialize('/*menu*/');
		$this->TreePaint(0,0);
	}
	function TreePaint($parent,$level){
		$i=0;
		$j=0;
		$node=array();
		foreach($this->menuTree as $i => $punkt){
			if($punkt['parent']==$parent){
				$node[$j]=$punkt;
				$j++;
			}
		}
		$max=$j-1;
		foreach($node as $i => $punkt){
			if($punkt['type']=='menu'){
				if($max>0){
					?><li class='Node ExpandLeaf'><?php
				}else{
					?><li class='Node ExpandLeaf IsLast'><?php
				}
				$max--;
				?><div class='Expand'></div>
				<div class='Content' style='cursor:pointer;'>
				<?php
				/*
				меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
				*/
				$next=$this->checkCRUDByParent($i);
				if($next===false){
					echo $punkt['name'];
				}else{
					$link=translit($this->menuTree[$next]['name']);
					?><a href="/<?php echo $link;?>"><?php echo $punkt['name'];?></a><?php
				}
				?>
				</div>
				<ul class='Container'><?php echo $this->TreePaint($i,$level+1);?>
				</ul>
				</li><?php
			}else{
				//ничего не делаем
			}
		}
	}
	function checkCRUDByParent($parent){
		//если находится CRUD или TreeCRUD, то вернуть id элемента, иначе вернуть false
		$result=false;
		foreach ($this->menuTree as $id => $element){
			if($element['type']=='CRUD' || $element['type']=='TreeCRUD'){
				$result=$id;
			}
		}
		return $result;
	}
	function getImgByType($type){
		switch($type){
			case 'menu':
				return 'menu.gif';
			break;
			case 'CRUD':
				return 'crud.gif';
			break;
			case 'TreeCRUD':
				return 'tree_crud.gif';
			break;
		}
	}
}
?><?php
class menuBO{
	var $menuTree;
	function Paint(){
		$sql="SELECT * FROM modules";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		$this->menuTree=array();
		for($i=0;$i<$n;$i++){
			$id=mysql_result($r,$i,'id');
			$parent=mysql_result($r,$i,'parent');
			$module=mysql_result($r,$i,'module');
			$title=mysql_result($r,$i,'title');
			$type=mysql_result($r,$i,'type');
			//проверяем права доступа
			if(checkAuthBO($_SESSION['user_id']*1,$module)){
				$this->menuTree[$id]=array("parent"=>$parent, "name"=>$title, "type"=>$type, "module"=>$module);
			}
		}
		echo $this->TreePaint(0,0);
	}
	function TreePaint($parent,$level){
		$s='';
		$i=0;
		$j=0;
		$node=array();
		foreach($this->menuTree as $id => $punkt){
			if($punkt['parent']==$parent){
				$node[$j]=array("id"=>$id, "punkt"=>$punkt);
				$j++;
			}
		}
		$max=$j-1;
		//если уровень нулевой, то пункты меню должны отображаться на горизонтальном слое,
		//статически "прижатом" к топу страницы
		if($level==0){
			$s.="<table style='position:absolute;left:0px;top:0px;width:100%' bgcolor='Aqua' border=0 cellspacing=0 cellpadding=0>
<tr>";
			foreach($node as $i => $punkt){
				if($punkt['punkt']['type']=='menu'){
					/*
					меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
					*/
					$next=$this->checkCRUDByParent($punkt['id']);
					$ts=$this->TreePaint($punkt['id'],$level+1);
					if($next===false){
						if($ts!=''){
							$s.="<td onmouseover=\"document.getElementById('mp$i').style.display='block';\" onmouseout=\"document.getElementById('mp$i').style.display='none';\" style='width:150px;'>".$punkt['punkt']['name'];
						}else{
							$s.="<td style='width:150px;'>".$punkt['punkt']['name'];
						}
					}else{
						$link=$this->menuTree[$next]['module'];
						$s.="<a href='?view=$link'>".$punkt['punkt']['name']."</a>";
					}
					if($ts!=''){
						$s.="<div id='mp$i' style='position:absolute; left:".(10+$i*150)."px;top:20px; display:none;background-color:Aqua;border:#00cccc 1px solid;'>$ts</div>";
					}
					$s.="</td>";
				}
			}
			//$s.="<td>&nbsp;</td></tr></table>";
		}else{
			foreach($node as $i => $punkt){
				if($punkt['punkt']['type']=='menu'){
					$s.="<div style='cursor:pointer; width:100%; background-color:#00ffff;' onmouseover='this.style.backgroundColor=\"#00cccc\";' onmouseout='this.style.backgroundColor=\"#00ffff\";'>";
					//
					//меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
					//
					$next=$this->checkCRUDByParent($punkt['id']);
					if($next===false){
						$s.=$punkt['punkt']['name'];
					}else{
						$link=$this->menuTree[$next]['module'];
						$s.="<a href='?view=$link'>".$punkt['punkt']['name']."</a>";
					}
					$s.="</div>
					<div>".$this->TreePaint($punkt['id'],$level+1)."</div>";
				}else{
					
				}
			}
			/*
		foreach($node as $i => $punkt){
			if($punkt['punkt']['type']=='menu'){
				if($max>0){
					?><li class='Node ExpandLeaf'><?php
				}else{
					?><li class='Node ExpandLeaf IsLast'><?php
				}
				$max--;
				?><div class='Expand'></div>
				<div class='Content' style='cursor:pointer;'>
				<?php
				
				//меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
				
				$next=$this->checkCRUDByParent($punkt['id']);
				if($next===false){
					echo $punkt['punkt']['name'];
				}else{
					$link=$this->menuTree[$next]['module'];
					?><a href="?view=<?php echo $link;?>"><?php echo $punkt['punkt']['name'];?></a><?php
				}
				?>
				</div>
				<ul class='Container'><?php echo $this->TreePaint($punkt['id'],$level+1);?>
				</ul>
				</li><?php
			}else{
				
			}*/
		}
		return $s;
	}
	function checkCRUDByParent($parent){
		//если находится CRUD или TreeCRUD, то вернуть id элемента, иначе вернуть false
		$result=false;
		foreach ($this->menuTree as $id => $element){
			if($element['parent']==$parent && ($element['type']=='CRUD' || $element['type']=='TreeCRUD')){
				$result=$id;
			}
		}
		return $result;
	}
	function getImgByType($type){
		switch($type){
			case 'menu':
				return 'menu.gif';
			break;
			case 'CRUD':
				return 'crud.gif';
			break;
			case 'TreeCRUD':
				return 'tree_crud.gif';
			break;
		}
	}
}
?><?php
class menuFO{
	var $menuTree;
	function Paint(){
		$sql="SELECT * FROM front_modules";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		$this->menuTree=array();
		for($i=0;$i<$n;$i++){
			$id=mysql_result($r,$i,'id');
			$parent=mysql_result($r,$i,'parent');
			$module=mysql_result($r,$i,'module');
			$title=mysql_result($r,$i,'title');
			$type=mysql_result($r,$i,'type');
			//проверяем права доступа
			if(checkAuthFO($_SESSION['front_user_id']*1,$module)){
				$this->menuTree[$id]=array("parent"=>$parent, "name"=>$title, "type"=>$type, "module"=>$module);
			}
		}
		echo $this->TreePaint(0,0);
	}
	function TreePaint($parent,$level){
		$s='';
		$i=0;
		$j=0;
		$node=array();
		foreach($this->menuTree as $id => $punkt){
			if($punkt['parent']==$parent){
				$node[$j]=array("id"=>$id, "punkt"=>$punkt);
				$j++;
			}
		}
		$max=$j-1;
		//если уровень нулевой, то пункты меню должны отображаться на горизонтальном слое,
		//статически "прижатом" к топу страницы
		if($level==0){
			$s.="<table style='position:absolute;left:0px;top:0px;width:100%' bgcolor='Aqua' border=0 cellspacing=0 cellpadding=0>
<tr>";
			foreach($node as $i => $punkt){
				if($punkt['punkt']['type']=='menu'){
					/*
					меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
					*/
					$next=$this->checkCRUDByParent($punkt['id']);
					$ts=$this->TreePaint($punkt['id'],$level+1);
					if($next===false){
						if($ts!=''){
							$s.="<td onmouseover=\"document.getElementById('mp$i').style.display='block';\" onmouseout=\"document.getElementById('mp$i').style.display='none';\" style='width:150px;'>".$punkt['punkt']['name'];
						}else{
							$s.="<td style='width:150px;'>".$punkt['punkt']['name'];
						}
					}else{
						$link=$this->menuTree[$next]['module'];
						$s.="<a href='?view=$link'>".$punkt['punkt']['name']."</a>";
					}
					if($ts!=''){
						$s.="<div id='mp$i' style='position:absolute; left:".(10+$i*150)."px;top:20px; display:none;background-color:Aqua;border:#00cccc 1px solid;'>$ts</div>";
					}
					$s.="</td>";
				}
			}
			//$s.="<td>&nbsp;</td></tr></table>";
		}else{
			foreach($node as $i => $punkt){
				if($punkt['punkt']['type']=='menu'){
					$s.="<div style='cursor:pointer; width:100%; background-color:#00ffff;' onmouseover='this.style.backgroundColor=\"#00cccc\";' onmouseout='this.style.backgroundColor=\"#00ffff\";'>";
					//
					//меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
					//
					$next=$this->checkCRUDByParent($punkt['id']);
					if($next===false){
						$s.=$punkt['punkt']['name'];
					}else{
						$link=$this->menuTree[$next]['module'];
						$s.="<a href='?view=$link'>".$punkt['punkt']['name']."</a>";
					}
					$s.="</div>
					<div>".$this->TreePaint($punkt['id'],$level+1)."</div>";
				}else{
					
				}
			}
			/*
			foreach($node as $i => $punkt){
				if($punkt['punkt']['type']=='menu'){
					if($max>0){
						?><li class='Node ExpandLeaf'><?php
					}else{
						?><li class='Node ExpandLeaf IsLast'><?php
					}
					$max--;
					?><div class='Expand'></div>
					<div class='Content' style='cursor:pointer;'>
					<?php
					//
					//меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
					//
					$next=$this->checkCRUDByParent($punkt['id']);
					if($next===false){
						echo $punkt['punkt']['name'];
					}else{
						$link=$this->menuTree[$next]['module'];
						?><a href="?view=<?php echo $link;?>"><?php echo $punkt['punkt']['name'];?></a><?php
					}
					?>
					</div>
					<ul class='Container'><?php echo $this->TreePaint($punkt['id'],$level+1);?>
					</ul>
					</li><?php
				}else{
					
				}
			}
			*/
		}
		return $s;
	}
	function checkCRUDByParent($parent){
		//если находится CRUD или TreeCRUD, то вернуть id элемента, иначе вернуть false
		$result=false;
		foreach ($this->menuTree as $id => $element){
			if($element['parent']==$parent && ($element['type']=='CRUD' || $element['type']=='TreeCRUD')){
				$result=$id;
			}
		}
		return $result;
	}
	function getImgByType($type){
		switch($type){
			case 'menu':
				return 'menu.gif';
			break;
			case 'CRUD':
				return 'crud.gif';
			break;
			case 'TreeCRUD':
				return 'tree_crud.gif';
			break;
		}
	}
}
?><?php
function makeViewCRUDclassFO($project, $pid, $tables){
	$crud=$project[$pid];
	$parent=$project[$crud['parent']];
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$childView='';
	$s="<?php
class ".$viewName."View{
	var \$db$mainTable[name];
	var \$list$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="var \$filter;
	var \$filter_check;
	var \$where='';
	var \$page=1;
	var \$limit=0;
	var \$order='';
	var \$cnt;
	var \$childView='';
	
	function ".$viewName."View(){
		//инициализация конфигурации
		if(!isset(\$_SESSION['$viewName'])){
			\$_SESSION['$viewName']['filter']=array();
			\$_SESSION['$viewName']['filter_check']=array();
			\$_SESSION['$viewName']['page']=1;
			\$_SESSION['$viewName']['limit']=100;
			\$_SESSION['$viewName']['order']='';
		}
		//собираем входные данные
		if(isset(\$_REQUEST['filter']) && is_array(\$_REQUEST['filter'])){
			\$_SESSION['$viewName']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			\$_SESSION['$viewName']['datafields']=array();
";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$s.="\$_SESSION['$viewName']['filter']['id'] = mysql_escape_string(\$_REQUEST['filter']['id']);//*
\$_SESSION['$viewName']['filter_check']['id'] = \$_REQUEST['filter_check']['id'] == 'on';
";
			}else{
				$type=$mainTable['fields'][$fname]['type'];
				if($type=='date'){
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_from'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_from']);
\$_SESSION['$viewName']['filter_check']['$fname"."_from'] = \$_REQUEST['filter_check']['$fname"."_from'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_from']='from';
";
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_to'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_to']);
\$_SESSION['$viewName']['filter_check']['$fname"."_to'] = \$_REQUEST['filter_check']['$fname"."_to'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_to']='to';
";
					$s.="";
				}else{
					$s.="\$_SESSION['$viewName']['datafields']['$fname']='$type';
\$_SESSION['$viewName']['filter']['$fname'] = mysql_escape_string(\$_REQUEST['filter']['$fname']);
\$_SESSION['$viewName']['filter_check']['$fname'] = \$_REQUEST['filter_check']['$fname'] == 'on';
";
				}
			}
		}
	}
			$s.="
		}
		if(isset(\$_REQUEST['start'])){\$_SESSION['$viewName']['page']=\$_REQUEST['page']*1;}
		if(isset(\$_REQUEST['limit'])){\$_SESSION['$viewName']['limit']=\$_REQUEST['limit']*1;}
		if(isset(\$_REQUEST['order'])){
			\$_SESSION['$viewName']['order'] = mysql_escape_string(\$_REQUEST['order']);
		}
//		if(isset(\$_REQUEST['filter_id'])){
//			\$_SESSION['$viewName']['filter']=array(\"id\"=>\$_REQUEST['filter_id']*1);
//		}
		
		\$this->filter=\$_SESSION['$viewName']['filter'];
		\$this->filter_check=\$_SESSION['$viewName']['filter_check'];
		\$this->start=\$_SESSION['$viewName']['page'];
		\$this->limit=\$_SESSION['$viewName']['limit'];
		\$this->order=\$_SESSION['$viewName']['order'];
		//создаём объекты доступа к таблицам
		\$this->db$mainTable[name]=new db$mainTable[name]();
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
		//создать из \$filter => \$where
		\$this->where='';
		\$d='';
		if(is_array(\$this->filter)){
			foreach (\$this->filter as \$fid => \$fval){
				if(\$this->filter_check[\$fid]){
					if(\$_SESSION['$viewName']['datafields'][\$fid]=='from'){
						\$p0=strpos(\$fid,'_from');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`>='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='to'){
						\$p0=strpos(\$fid,'_to');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`<='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='string'){
						\$this->where.=\$d.\"`\$fid` LIKE '\$fval'\";
					}else{
						\$this->where.=\$d.\"`\$fid`='\$fval'\";
					}
					\$d=' AND ';
				}
			}
		}
		\$this->cnt = \$this->db$mainTable[name]->count(\$this->where);
		
		//получаем основной лист
		\$start=(\$this->page - 1) * \$this->limit;
		\$this->list$mainTable[name]=\$this->db$mainTable[name]->load(\$this->where, \$this->order, \$start, \$this->limit);
		";
		//определяем наличие потомка
		if($crud['content']['thistable']!=null && $crud['content']['childtable']!=null){
			$s.="//есть потомок
";
			//ищем потомка
			foreach ($project as $lpid => $element){
				if($element['parent']==$pid){
					$childView=translit($element['name']);
					$s.="\$this->childView='".$childView."';
";
				}
			}
		}
		$s.="
	}
	
	function Paint(){
		?>";
		//проверить, кто parent
		if($parent['type']=='CRUD' || $parent['type']=='TreeCRUD'){
			$s.="<a href='?view=".translit( $parent['name'] )."View'>&lt;&lt;&lt;&lt; Назад</br>";
		}
		$s.="
<form action='?view=$viewName"."View' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>";
		$col='eeeeee';
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			$s.="
<td valign=top bgcolor='#$col' nowrap>";
			if($col=='eeeeee'){$col='dddddd';}else{$col='eeeeee';}
			switch ($type){
				case 'on_off':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=checkbox name='filter[$fname]' value='on' <?php if(\$this->filter['$fname']!=0){?> checked<?php }?>'>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUpList(\$this->list$lookUpTable[name], \$this->filter['$fname'], '$field[lookupfield]', 'filter[$fname]'));?>";
					}else{
						$s.="<input class=filter type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
					}
				break;
				case 'string':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input class=filter type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'date':
					$s.="<input type='checkbox' name='filter_check[$fname"."_from]' <?php if(\$this->filter_check['$fname"."_from']){ echo(\" checked\");}?> value='on'>$fname"."_from:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_from_fd' name='filter[$fname"."_from]' value='<?php echo(\$this->filter['$fname"."_from']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_from_fd', 'datetime', 'filter_$fname"."_from_fd');\"><br>";
					$s.="<input type='checkbox' name='filter_check[$fname"."_to]' <?php if(\$this->filter_check['$fname"."_to']){ echo(\" checked\");}?> value='on'>$fname"."_to:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_to_fd' name='filter[$fname"."_to]' value='<?php echo(\$this->filter['$fname"."_to']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_to_fd', 'datetime', 'filter_$fname"."_to_fd');\">";
				break;
				case 'text':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input class=filter type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'file':
					$s.="";
				break;
			}
$s.="</td>";
		}
	}
$s.="</tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href=\"?view=$viewName"."View&action=add$viewName"."Action\"'><br>
Страница: <?php \$this->shkala(); ?>
<table border=\"0\" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
<td>$fname</td>";
		}
	}
	$s.="
<td></td>
<td></td>";
	if($childView!=''){
		$s.="
<td></td>";
	}
	$s.="
</tr>
<?php
		\$col='eeeeee';
		foreach (\$this->list$mainTable[name] as \$i => \$onerec){
			?><tr bgcolor='#<?=\$col?>'>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
	<td>";
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			switch ($type){
				case 'on_off':
					$s.="<?php if(\$onerec['$fname']!=0){?>ON<?php }else{?>OFF<?php }?>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$onerec['$fname'], '$field[lookupfield]'));?>";
					}else{
						$s.="<?php echo(\$onerec['$fname']);?>";
					}
				break;
				case 'string':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'date':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'text':
					$s.="<?php echo(\$this->longText(\$onerec['$fname']));?>";
				break;
				case 'file':
					$s.="<?php echo(\$this->photo(\$onerec['id'], '$fname'));?>";
				break;
			}
			$s.="</td>";
		}
	}
			$s.="
	<td><a href='?view=$viewName"."Edit&id=<?=\$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=$viewName"."View&action=del$viewName"."Action&id=<?=\$onerec['id']?>'><img src='images/b_drop.png'></a></td>";
	if($childView!=''){
		$s.="
<td><a href='?view=$childView"."View&filter_check[".$crud['content']['childtable']."]=on&filter[".$crud['content']['childtable']."]=<?=\$onerec['".$crud['content']['thistable']."']?>'>Next</a></td>";
	}
	$s.="
</tr><?php
			if(\$col=='eeeeee'){\$col='dddddd';}else{\$col='eeeeee';}
		}
?>
</table>
Страница: <?php
		\$this->shkala();
	}
	function lookUp(&\$list, \$id, \$field_name){
		\$res=false;
		\$fna=explode(\":\",\$field_name);
		foreach (\$list as \$rec){
			if(\$rec['id']==\$id){
				\$res='';
				foreach (\$fna as \$ofn){
					\$res.=\$rec[\$ofn].' ';
				}
			}
		}
		return \$res;
	}
	function lookUpList(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\".\$rec['id'].\"'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.=\">\";
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function longText(\$s, \$len=50){
		if(strlen(\$s)>\$len){
			return substr(\$s,0,\$len).'...';
		}else{
			return \$s;
		}
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
	function shkala(){
		\$cnt=round(\$this->cnt / \$this->limit + 0.5);
		for(\$i=0;\$i<\$cnt;\$i++){
			if(\$i>0){
				?> | <?php
			}
			if(\$i+1==\$this->page){
				echo (\$i+1);
			}else{
				?><a href='?view=$viewName"."View&page=<?php echo(\$i);?>'><?php echo (\$i+1);?></a><?php
			}
		}
	}
}
?>";
	return $s;
}
?><?php
class CRUDpattern{
	var $dbproduct;
	var $dbcategory;
	var $listProduct;
	var $listCategory;
	var $filter;
	var $where;
	var $page;
	var $limit;
	var $order;
	var $cnt;
	
	function CRUDpattern(){
		//инициализация конфигурации
		if(!isset($_SESSION['CRUDpattern'])){
			$_SESSION['CRUDpattern']['filter']=array();
			$_SESSION['CRUDpattern']['page']=1;
			$_SESSION['CRUDpattern']['limit']=100;
			$_SESSION['CRUDpattern']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['CRUDpattern']['filter']=array();
			//перебираем поля формы фильтра
			foreach ($_REQUEST['filter'] as $fid=>$fval){
				//если чекбокс данного фильтра включён, то запоминаем его состояние
				if($_REQUEST['filter_check'][$fid]=='on'){
					$_SESSION['CRUDpattern']['filter'][mysql_escape_string($fid)] = mysql_escape_string($fval);
				}
			}
		}
		if(isset($_REQUEST['start'])){$_SESSION['CRUDpattern']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['CRUDpattern']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['CRUDpattern']['order'] = mysql_escape_string($_REQUEST['order']);
		}
		if(isset($_REQUEST['filter_id'])){
			$_SESSION['CRUDpattern']['filter']=array("id"=>$_REQUEST['filter_id']*1);
		}
		
		$this->filter=$_SESSION['CRUDpattern']['filter'];
		$this->start=$_SESSION['CRUDpattern']['page'];
		$this->limit=$_SESSION['CRUDpattern']['limit'];
		$this->order=$_SESSION['CRUDpattern']['order'];
		
		//создаём объекты доступа к таблицам
		$this->dbproduct=new dbproduct();
		$this->dbcategory=new dbcategory();
		
		//создать из $filter => $where
		$this->where='';
		$d='';
		foreach ($this->filter as $fid => $fval){
			$this->where.=$d."`$fid`='$fval'";
			$d=' AND ';
		}
		
		$this->cnt = $this->dbproduct->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listProduct=$this->dbproduct->load($this->where, $this->order, $start, $this->limit);
		
		//получаем лист для lookUp
		$this->listCategory=$this->dbcategory->load('','',0,0);
	}
	
	function Paint(){
		$this->shkala();
		?><a href='?view=CRUDpattern&action=addProduct'>Add</a>
<table border="1">
<tr>
	<td>id</td>
	<td>category</td>
	<td>name</td>
	<td>desc</td>
	<td>photo</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<?php
		foreach ($this->listProduct as $i => $onerec){
			?><tr>
	<td><?=$onerec['id']?></td>
	<td><?php echo($this->lookUp($this->listCategory, $onerec['category'], 'category'));?></td>
	<td><?=$onerec['name']?></td>
	<td><?php echo($this->longText($onerec['desc']));?></td>
	<td><?php echo($this->photo($onerec['photo']));?></td>
	<td><a href='?view=editProduct&id=<?=$onerec['id']?>'>Edit</a></td>
	<td><a href='?view=CRUDpattern&action=delProduct&id=<?=$onerec['id']?>'>Del</a></td>
	<td><a href='?view=nextCRUDpattern&next_id=<?=$onerec['category']?>'>Next</a></td>
</tr><?php
		}
?>
</table>
		<?php
		$this->shkala();
	}
	function lookUp(&$list, $id, $field_name){
		$res=false;
		foreach ($list as $rec){
			if($rec['id']==$id){
				$res=$rec[$field_name];
			}
		}
		return $res;
	}
	function longText($s, $len){
		if(strlen($s)>$len){
			return substr($s,0,$len).'...';
		}else{
			return $s;
		}
	}
	function photo($photo){
		$path=photoPath($photo);
		if(file_exists($path)){
			return "<img src='$path'>";
		}else{
			return './photo/noimage.png';
		}
	}
	function shkala(){
		$cnt=round($this->cnt / $this->limit + 0.5);
		for($i=0;$i<$cnt;$i++){
			if($i>0){
				?> | <?php
			}
			if($i+1==$this->page){
				echo ($i+1);
			}else{
				?><a href='?view=CRUDpattern&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?><?php
function makeViewCRUDclass($project, $pid, $tables){
	$crud=$project[$pid];
	$parent=$project[$crud['parent']];
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$childView='';
	$s="<?php
class ".$viewName."ViewBO{
	var \$db$mainTable[name];
	var \$list$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="var \$filter;
	var \$filter_check;
	var \$where='';
	var \$page=1;
	var \$limit=0;
	var \$order='';
	var \$cnt;
	var \$childView='';
	
	function ".$viewName."ViewBO(){
		//инициализация конфигурации
		if(!isset(\$_SESSION['$viewName'])){
			\$_SESSION['$viewName']['filter']=array();
			\$_SESSION['$viewName']['filter_check']=array();
			\$_SESSION['$viewName']['page']=1;
			\$_SESSION['$viewName']['limit']=100;
			\$_SESSION['$viewName']['order']='';
		}
		//собираем входные данные
		if(isset(\$_REQUEST['filter']) && is_array(\$_REQUEST['filter'])){
			\$_SESSION['$viewName']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			\$datafields=array();
";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$s.="\$_SESSION['$viewName']['filter']['id'] = mysql_escape_string(\$_REQUEST['filter']['id']);//*
\$_SESSION['$viewName']['filter_check']['id'] = \$_REQUEST['filter_check']['id'] == 'on';
";
			}else{
				$type=$mainTable['fields'][$fname]['type'];
				if($type=='date'){
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_from'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_from']);
\$_SESSION['$viewName']['filter_check']['$fname"."_from'] = \$_REQUEST['filter_check']['$fname"."_from'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_from']='from';
";
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_to'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_to']);
\$_SESSION['$viewName']['filter_check']['$fname"."_to'] = \$_REQUEST['filter_check']['$fname"."_to'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_to']='to';
";
					$s.="";
				}else{
					$s.="\$_SESSION['$viewName']['datafields']['$fname']='$type';
\$_SESSION['$viewName']['filter']['$fname'] = mysql_escape_string(\$_REQUEST['filter']['$fname']);
\$_SESSION['$viewName']['filter_check']['$fname'] = \$_REQUEST['filter_check']['$fname'] == 'on';
";
				}
			}
		}
	}
			$s.="
		}
		if(isset(\$_REQUEST['start'])){\$_SESSION['$viewName']['page']=\$_REQUEST['page']*1;}
		if(isset(\$_REQUEST['limit'])){\$_SESSION['$viewName']['limit']=\$_REQUEST['limit']*1;}
		if(isset(\$_REQUEST['order'])){
			\$_SESSION['$viewName']['order'] = mysql_escape_string(\$_REQUEST['order']);
		}
//		if(isset(\$_REQUEST['filter_id'])){
//			\$_SESSION['$viewName']['filter']=array(\"id\"=>\$_REQUEST['filter_id']*1);
//		}
		
		\$this->filter=\$_SESSION['$viewName']['filter'];
		\$this->filter_check=\$_SESSION['$viewName']['filter_check'];
		\$this->start=\$_SESSION['$viewName']['page'];
		\$this->limit=\$_SESSION['$viewName']['limit'];
		\$this->order=\$_SESSION['$viewName']['order'];
		//создаём объекты доступа к таблицам
		\$this->db$mainTable[name]=new db$mainTable[name]();
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
		
		//создать из \$filter => \$where
		\$this->where='';
		\$d='';
		if(is_array(\$this->filter)){
			foreach (\$this->filter as \$fid => \$fval){
				if(\$this->filter_check[\$fid]){
					if(\$_SESSION['$viewName']['datafields'][\$fid]=='from'){
						\$p0=strpos(\$fid,'_from');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`>='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='to'){
						\$p0=strpos(\$fid,'_to');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`<='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='string'){
						\$this->where.=\$d.\"`\$fid` LIKE '\$fval'\";
					}else{
						\$this->where.=\$d.\"`\$fid`='\$fval'\";
					}
					\$d=' AND ';
				}
			}
		}
		\$this->cnt = \$this->db$mainTable[name]->count(\$this->where);
		
		//получаем основной лист
		\$start=(\$this->page - 1) * \$this->limit;
		\$this->list$mainTable[name]=\$this->db$mainTable[name]->load(\$this->where, \$this->order, \$start, \$this->limit);
		";
		//определяем наличие потомка
		if($crud['content']['thistable']!=null && $crud['content']['childtable']!=null){
			$s.="//есть потомок
";
			//ищем потомка
			foreach ($project as $lpid => $element){
				if($element['parent']==$pid){
					$childView=translit($element['name']);
					$s.="\$this->childView='".$childView."';
";
				}
			}
		}
		$s.="
	}
	
	function Paint(){
		?>
";
		//проверить, кто parent
		if($parent['type']=='CRUD' || $parent['type']=='TreeCRUD'){
			$s.="<a href='?view=".translit( $parent['name'] )."ViewBO'>&lt;&lt;&lt;&lt; Назад</br>";
		}
		$s.="
<form action='?view=$viewName"."ViewBO' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>";
		$col='eeeeee';
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			$s.="
<td valign=top bgcolor='#$col' nowrap>";
			if($col=='eeeeee'){$col='dddddd';}else{$col='eeeeee';}
			switch ($type){
				case 'on_off':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=checkbox name='filter[$fname]' value='on' <?php if(\$this->filter['$fname']!=0){?> checked<?php }?>'>";
				break;
				case 'int':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					//проверить, не является ли lookUp
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUpList(\$this->list$lookUpTable[name], \$this->filter['$fname'], '$field[lookupfield]', 'filter[$fname]'));?>";
					}else{
						$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
					}
				break;
				case 'string':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input class=filter type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'date':
					$s.="<input type='checkbox' name='filter_check[$fname"."_from]' <?php if(\$this->filter_check['$fname"."_from']){ echo(\" checked\");}?> value='on'>$fname"."_from:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_from_fd' name='filter[$fname"."_from]' value='<?php echo(\$this->filter['$fname"."_from']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_from_fd', 'datetime', 'filter_$fname"."_from_fd');\"><br>";
					$s.="<input type='checkbox' name='filter_check[$fname"."_to]' <?php if(\$this->filter_check['$fname"."_to']){ echo(\" checked\");}?> value='on'>$fname"."_to:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_to_fd' name='filter[$fname"."_to]' value='<?php echo(\$this->filter['$fname"."_to']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_to_fd', 'datetime', 'filter_$fname"."_to_fd');\">";
				break;
				case 'text':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input class=filter type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'file':
					$s.="";
				break;
			}
$s.="</td>";
		}
	}
$s.="</tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href=\"?view=$viewName"."ViewBO&action=add$viewName"."ActionBO\"'><br>
Страница: <?php \$this->shkala();?>
<table border=\"1\">
<tr bgcolor='#cccccc'>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
<td>$fname</td>";
		}
	}
	$s.="
<td></td>
<td></td>";
	if($childView!=''){
		$s.="
<td></td>";
	}
	$s.="
</tr>
<?php
		\$col='eeeeee';
		foreach (\$this->list$mainTable[name] as \$i => \$onerec){
			?><tr bgcolor='#<?=\$col?>'>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
	<td>";
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			switch ($type){
				case 'on_off':
					$s.="<?php if(\$onerec['$fname']!=0){?>ON<?php }else{?>OFF<?php }?>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$onerec['$fname'], '$field[lookupfield]'));?>";
					}else{
						$s.="<?php echo(\$onerec['$fname']);?>";
					}
				break;
				case 'string':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'date':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'text':
					$s.="<?php echo(\$this->longText(\$onerec['$fname']));?>";
				break;
				case 'file':
					$s.="<?php echo(\$this->photo(\$onerec['id'], '$fname'));?>";
				break;
			}
			$s.="</td>";
		}
	}
			$s.="
	<td><a href='?view=$viewName"."EditBO&id=<?=\$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=$viewName"."ViewBO&action=del$viewName"."ActionBO&id=<?=\$onerec['id']?>'><img src='images/b_drop.png'></a></td>";
	if($childView!=''){
		$s.="
<td><a href='?view=$childView"."ViewBO&filter_check[".$crud['content']['childtable']."]=on&filter[".$crud['content']['childtable']."]=<?=\$onerec['".$crud['content']['thistable']."']?>'>Next</a></td>";
	}
	$s.="
</tr><?php
			if(\$col=='eeeeee'){\$col='dddddd';}else{\$col='eeeeee';}
		}
?>
</table>
Страница: <?php
		\$this->shkala();
	}
	function lookUp(&\$list, \$id, \$field_name){
		\$res=false;
		\$fna=explode(\":\",\$field_name);
		foreach (\$list as \$rec){
			if(\$rec['id']==\$id){
				\$res='';
				foreach (\$fna as \$ofn){
					\$res.=\$rec[\$ofn].' ';
				}
			}
		}
		return \$res;
	}
	function lookUpList(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\".\$rec['id'].\"'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.=\">\";
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function longText(\$s, \$len=50){
		if(strlen(\$s)>\$len){
			return substr(\$s,0,\$len).'...';
		}else{
			return \$s;
		}
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
	function shkala(){
		\$cnt=round(\$this->cnt / \$this->limit + 0.5);
		for(\$i=0;\$i<\$cnt;\$i++){
			if(\$i>0){
				?> | <?php
			}
			if(\$i+1==\$this->page){
				echo (\$i+1);
			}else{
				?><a href='?view=$viewName"."ViewBO&page=<?php echo(\$i);?>'><?php echo (\$i+1);?></a><?php
			}
		}
	}
}
?>";
	return $s;
}
?><?php
function makeDBclass($table){
$s='class db'.$table['name'].'{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `'.$table['name'].'`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `'.$table['name'].'`";
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
';			
			foreach ($table['fields'] as $field_name => $field){
				$s.="\$$field_name = mysql_result(\$r,\$i,'$field_name');
";
			}
			$s.="\$list[]=array(\"id\"=>\$id";
			foreach ($table['fields'] as $field_name => $field){
				$s.=", \"$field_name\"=>\$$field_name";
			}
			$s.=');
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `'.$table['name'].'` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
';
			foreach ($table['fields'] as $field_name => $field){
				$s.="\$$field_name = mysql_result(\$r,\$i,'$field_name');
";
			}
			$s.='return array("id"=>$id';
			foreach ($table['fields'] as $field_name => $field){
				$s.=", \"$field_name\"=>\$$field_name";
			}
			$s.=');
		}else{
			return false;
		}
	}
	function add(';
	$d='';
	foreach ($table['fields'] as $field_name => $field){
		$s.=$d.'$'.$field_name;
		$d=', ';
	}
	$s.='){
		$sql="INSERT INTO `'.$table['name'].'`(';
	$d='';
		foreach ($table['fields'] as $field_name => $field){
			$s.=$d.'`'.$field_name.'`';
			$d=', ';
		}
		$s.=') VALUES(';
		$d='';
		foreach ($table['fields'] as $field_name => $field){
			$s.=$d.'\'$'.$field_name.'\'';
			$d=', ';
		}
		$s.=')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `'.$table['name'].'` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id';
	foreach ($table['fields'] as $field_name => $field){
		$s.=', $'.$field_name;
	}
	$s.='){
		$sql="UPDATE `'.$table['name'].'` SET ";
		$d=\'\';';
		foreach ($table['fields'] as $field_name => $field){
			$s.="if(\$$field_name!==null){
				\$sql.=\$d.' `$field_name`=\"'.\$$field_name.'\"';
				\$d=', ';
			}";
		}
		$s.='
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}';
		return $s;
}
?><?php
function makeEditCRUDclassFO($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class ".$viewName."Edit{
	var \$id;
	var \$db$mainTable[name];
	var \$$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="function ".$viewName."Edit(){
		\$this->id=\$_REQUEST['id']*1;
		\$this->db$mainTable[name] = new db$mainTable[name]();
		\$this->$mainTable[name] = \$this->db$mainTable[name]->get(\$this->id);
		
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
	}
	function Paint(){
		?>
		<a href='?view=".$viewName."View'>К списку</a>
		<table border=\"1\">
		<form method=\"POST\" enctype=\"multipart/form-data\" action=\"?view=".$viewName."Edit&action=update".$viewName."Action&id=<?=\$this->id?>\">
";
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				$s.="
			<tr><td>$fname</td><td>";
				if($fname=='ID'){
					$type='int';
					$fname='id';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				switch ($type){
					case 'on_off':
						$s.="<input type=checkbox name=\"$fname\" value='1' <?php if(\$this->$mainTable[name]"."['$fname']!=0){ ?> checked<?php } ?>>";
					break;
					case 'int':
						//проверить, не является ли lookUp
						if($field['lookup']>0){
							$lookUpTable=$tables[$field['lookup']];
							$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$this->$mainTable[name]"."['$fname'], '$field[lookupfield]', '$fname'));?>";
						}else{
							$s.="<input type=\"text\" name=\"$fname\" value=\"<?php echo(\$this->$mainTable[name]"."['$fname']);?>\">";
						}
					break;
					case 'string':
						$s.="<input type=\"text\" name=\"$fname\" value=\"<?php echo(htmlspecialchars(\$this->$mainTable[name]"."['$fname']));?>\">";
					break;
					case 'date':
						$s.="<input type=\"text\" name=\"$fname\" id=\"$fname"."_fd\" value=\"<?php echo(\$this->$mainTable[name]"."['$fname']);?>\"><img src='images/b_calendar.png' onclick=\"openCalendar('', '', '$fname"."_fd', 'datetime', '$fname"."_fd');\">";
					break;
					case 'text':
						$s.="<textarea name=\"$fname\"><?php echo(\$this->$mainTable[name]"."['$fname']);?></textarea>";
					break;
					case 'file':
						$s.="<?php echo(\$this->photo(\$this->id, '$fname'));?><br><input type=\"file\" name=\"$fname\">";
					break;
				}
				$s.="</td></tr>";
			}
		}
		$s.="
		<tr><td colspan=\"2\"><input value=\" O.K. \" type=\"submit\"></td></tr>
		</form>
		</table>
		<?php
	}
	function lookUp(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\$rec[id]'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.='>';
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
}
?>";
	return $s;
}
?><?php
class editProductViewBO{
	var $id;
	var $dbproduct;
	var $product;
	var $dbcategory;
	var $listcategory;
	function editProductViewBO(){
		$this->id=$_REQUEST['id']*1;
		$this->dbproduct = new dbproduct();
		$this->product = $this->dbproduct->get($this->id);
		$this->dbcategory = new dbcategory();
		$this->listcategory = $this->dbcategory->load('','',0,0);
	}
	function Paint(){
		?>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=editProductViewBO&id=<?=$this->id?>">
		<tr><td>id</td><td><?=$this->product['id']?></td></tr>
		<tr><td>category</td><td><?php echo($this->lookUp($this->listcategory, $this->product['category'], 'category', 'category'));?></td></tr>
		<tr><td>name</td><td><input type="text" name="name" value="<?=$this->product['name']?>"></td></tr>
		<tr><td>desc</td><td><textarea name="desc"><?=$this->product['desc']?></textarea></td></tr>
		<tr><td>photo</td><td>
			<img src="<?php echo(photoPath($this->product['photo']));?>">
			<br><input type="file" name="photo">
			</td></tr>
		<tr><td colspan="2"><input value=" O.K. " type="submit"></td></tr>
		</form>
		</table>
		<?php
	}
	function lookUp(&$list, $id, $field_name, $name){
		$s="<select name='$name'>
";
		if(is_array($list)){
			foreach ($list as $rec){
				$s.="<option value=''";
				if($rec['id']==$id){
					$s.=" select";
				}
				$s.=">$rec[$field_name]</option>
";
			}
		}
		$s.="</select>
";
		return $s;
	}
}
?><?php
function makeEditCRUDclass($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class ".$viewName."EditBO{
	var \$id;
	var \$db$mainTable[name];
	var \$$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="function ".$viewName."EditBO(){
		\$this->id=\$_REQUEST['id']*1;
		\$this->db$mainTable[name] = new db$mainTable[name]();
		\$this->$mainTable[name] = \$this->db$mainTable[name]->get(\$this->id);
		
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
	}
	function Paint(){
		?>
		<a href='?view=".$viewName."ViewBO'>К списку</a>
		<table border=\"1\">
		<form method=\"POST\" enctype=\"multipart/form-data\" action=\"?view=".$viewName."EditBO&action=update".$viewName."ActionBO&id=<?=\$this->id?>\">
";
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				$s.="
			<tr><td>$fname</td><td>";
				if($fname=='ID'){
					$type='int';
					$fname='id';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				switch ($type){
					case 'on_off':
						$s.="<input type=checkbox name=\"$fname\" value='1' <?php if(\$this->$mainTable[name]"."['$fname']!=0){ ?> checked<?php } ?>>";
					break;
					case 'int':
						//проверить, не является ли lookUp
						if($field['lookup']>0){
							$lookUpTable=$tables[$field['lookup']];
							$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$this->$mainTable[name]"."['$fname'], '$field[lookupfield]', '$fname'));?>";
						}else{
							$s.="<input type=\"text\" name=\"$fname\" value=\"<?php echo(\$this->$mainTable[name]"."['$fname']);?>\">";
						}
					break;
					case 'string':
						$s.="<input type=\"text\" name=\"$fname\" value=\"<?php echo(htmlspecialchars(\$this->$mainTable[name]"."['$fname']));?>\">";
					break;
					case 'date':
						$s.="<input type=\"text\" name=\"$fname\" id=\"$fname"."_fd\" value=\"<?php echo(\$this->$mainTable[name]"."['$fname']);?>\"><img src='images/b_calendar.png' onclick=\"openCalendar('', '', '$fname"."_fd', 'datetime', '$fname"."_fd');\">";
					break;
					case 'text':
						$s.="<textarea name=\"$fname\"><?php echo(\$this->$mainTable[name]"."['$fname']);?></textarea>";
					break;
					case 'file':
						$s.="<?php echo(\$this->photo(\$this->id, '$fname'));?><br><input type=\"file\" name=\"$fname\">";
					break;
				}
				$s.="</td></tr>";
			}
		}
		$s.="
		<tr><td colspan=\"2\"><input value=\" O.K. \" type=\"submit\"></td></tr>
		</form>
		</table>
		<?php
	}
	function lookUp(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\$rec[id]'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.='>';
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
}
?>";
	return $s;
}
?><?php
session_start();
require_once('connect_db.php');
require_once('authFO.php');
require_once('lib.php');
requireDir('Models/');
requireDir('View/');
requireDir('Action/');

//проверяем попытку авторизации
if(isset($_REQUEST['login']) && isset($_REQUEST['password'])){
	loginFO($_REQUEST['login'], $_REQUEST['password']);
}

$menu = new menuFO();

if(isset($_REQUEST['action'])){
	//проверит авторизацию
	if(checkAuthFO($_SESSION['front_user_id'], $_REQUEST['action'])){
		eval("\$action=new $_REQUEST[action]();");
		$action->Go();
	}
}
if(isset($_REQUEST['view'])){
	//проверит авторизацию
	if(checkAuthFO($_SESSION['front_user_id'], $_REQUEST['view'])){
		eval("\$view=new $_REQUEST[view]();");
	}
}else{
	$view=null;
}
?>
<html>
<head>
<title>Tarion</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="tbl_change.js"></script>
<?php $menu->Paint();?>
<td align="right">
<input type="button" onclick="document.getElementById('authTable').style.display='block';" value="Авторизация">
</td>
</tr>
</table>
<table id='authTable' style="position:absolute;top:300px;left:300px;width:150px;background-color:Aqua;display:none;">
<form method="POST" action="">
<tr><td>login:</td><td><input type="text" name="login" style="width:80px;height:18px;"></td></tr>
<tr><td>password:</td><td><input type="password" name="password" style="width:80px;height:18px;"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Вход" style="height:18px;"></td></tr>
<tr><td colspan="2" align="center"><a href="?view=registrFormView">Регистрация</a></td></tr>
</form>
</table>
<script>
document.getElementById('authTable').style.left=Math.round(document.body.clientWidth/2 - 150/2);
</script>

<br>
<table width="100%" border="1">
<tr></tr>
	<td valign="top"><?php if($view!=null){$view->Paint();}?></td>
</tr>
</table>
</body>
</html><?php
/**
* transliterate text
*
* @param string $text
* @return string
*/
function translit($text) {
	$lat='QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890_';
	$trans = array(
"а" => "a",
"б" => "b",
"в" => "v",
"г" => "g",
"д" => "d",
"е" => "e",
"ё" => "e",
"ж" => "zh",
"з" => "z",
"и" => "i",
"й" => "y",
"к" => "k",
"л" => "l",
"м" => "m",
"н" => "n",
"о" => "o",
"п" => "p",
"р" => "r",
"с" => "s",
"т" => "t",
"у" => "u",
"ф" => "f",
"х" => "kh",
"ц" => "ts",
"ч" => "ch",
"ш" => "sh",
"щ" => "shch",
"ы" => "y",
"э" => "e",
"ю" => "yu",
"я" => "ya",
"А" => "A",
"Б" => "B",
"В" => "V",
"Г" => "G",
"Д" => "D",
"Е" => "E",
"Ё" => "E",
"Ж" => "Zh",
"З" => "Z",
"И" => "I",
"Й" => "Y",
"К" => "K",
"Л" => "L",
"М" => "M",
"Н" => "N",
"О" => "O",
"П" => "P",
"Р" => "R",
"С" => "S",
"Т" => "T",
"У" => "U",
"Ф" => "F",
"Х" => "Kh",
"Ц" => "Ts",
"Ч" => "Ch",
"Ш" => "Sh",
"Щ" => "Shch",
"Ы" => "Y",
"Э" => "E",
"Ю" => "Yu",
"Я" => "Ya",
"ь" => "",
"Ь" => "",
"ъ" => "",
"Ъ" => ""
 );
	if(preg_match("/[а-яА-Я]/", $text)){
		$s=strtr($text, $trans);
	}else{
		$s=$text;
	}
	for ($i=0;$i<strlen($s);$i++){
		if(strpos($lat,$s[$i])===false){$s[$i]='_';}
	}
	return $s;
}

function photoPath($photo){
	$path='./photo/'.round($photo/1000);
	if(!file_exists($path)){
		mkdir($path);
		chmod($path, 0777);
	}
	$path.='/'.$photo;
	if(!file_exists($path)){
		mkdir($path);
		chmod($path, 0777);
	}
	return $path;
}

function requireDir($path){
	$d=dir($path);
	while (false !== ($entry = $d->read())) {
		if($entry!='.' && $entry!='..'){
			require_once($path.$entry);
		}
	}
	$d->close();
}
?><?php
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
?><?php
function makeRegistredFormBO($tables){
	$s="<?php
class registredFormViewBO{
	function registredFormViewBO(){}
	function Paint(){
?>
Вы зарегистрированы с минимальными правами. Обратитесь к администратору.
<table border=\"1\">
<tr>
	<td>login</td>
	<td><?php echo \$_SESSION['registr']['login'];?></td>
</tr>
";
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){
		$s.="<tr>
	<td>$fname</td>
	<td><?php echo \$_SESSION['registr']['$fname'];?></td>
</tr>
";
		}
	}
$s.="
</table>
<?php
	}
}
?>";
	return $s;
}
?><?php
function makeRegistredFormFO($tables){
	$s="<?php
class registredFormView{
	function registredFormView(){}
	function Paint(){
?>
Вы зарегистрированы с минимальными правами. Обратитесь к администратору.
<table border=\"1\">
<tr>
	<td>login</td>
	<td><?php echo \$_SESSION['registr']['login'];?></td>
</tr>
";
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){
		$s.="<tr>
	<td>$fname</td>
	<td><?php echo \$_SESSION['registr']['$fname'];?></td>
</tr>
";
		}
	}
$s.="
</table>
<?php
	}
}
?>";
	return $s;
}
?><?php
function makeRegistrFormBO($tables){
	$s="<?php
class registrFormViewBO{
	function registrFormViewBO(){}
	function Paint(){
?>
<form method=\"POST\" action=\"?view=registredFormViewBO&action=registrFormActionBO\">
<table border=\"1\">
<tr>
	<td>login</td>
	<td><input type=\"text\" name=\"login\" value=\"<?php echo \$_SESSION['registr']['login'];?>\"></td>
</tr>
<tr>
	<td>password</td>
	<td><input type=\"password\" name=\"password\"></td>
</tr>
<tr>
	<td>Подтвердите пароль</td>
	<td><input type=\"password\" name=\"password2\"><?php
	if(\$_SESSION['registr']['error']=='password error'){?><br>
Вы ввели разные пароли.
	<?php
	}
	?></td>
</tr>";
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){
		$s.="<tr>
	<td>$fname</td>
	<td><input type='text' name='$fname' value='<?php echo \$_SESSION['registr']['$fname'];?>'></td>
</tr>
";
		}
	}
$s.="<tr>
	<td><img src='capche.php?dt=<?php echo date('H:i:s');?>'></td>
	<td><input type=\"text\" name=\"capche\"><?php if(\$_SESSION['registr']['error']=='capche error'){?>Вы неверно ввели контрольный код.<?php
	}?></td>
</tr>
<tr>
	<td colspan=2><input type=\"submit\" value=\"Зарегистрироваться\"></td>
</tr></table>
</form>
<?php
	}
}
?>";
	return $s;
}
?><?php
function makeRegistrFormFO($tables){
	$s="<?php
class registrFormView{
	function registrFormView(){}
	function Paint(){
?>
<form method=\"POST\" action=\"?view=registredFormView&action=registrFormAction\">
<table border=\"1\">
<tr>
	<td>login</td>
	<td><input type=\"text\" name=\"login\" value=\"<?php echo \$_SESSION['registr']['login'];?>\"></td>
</tr>
<tr>
	<td>password</td>
	<td><input type=\"password\" name=\"password\"></td>
</tr>
<tr>
	<td>Подтвердите пароль</td>
	<td><input type=\"password\" name=\"password2\"><?php
	if(\$_SESSION['registr']['error']=='password error'){?><br>
Вы ввели разные пароли.
	<?php
	}
	?></td>
</tr>";
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){
		$s.="<tr>
	<td>$fname</td>
	<td><input type='text' name='$fname' value='<?php echo \$_SESSION['registr']['$fname'];?>'></td>
</tr>
";
		}
	}
$s.="<tr>
	<td><img src='capche.php?dt=<?php echo date('H:i:s');?>'></td>
	<td><input type=\"text\" name=\"capche\"><?php if(\$_SESSION['registr']['error']=='capche error'){?>Вы неверно ввели контрольный код.<?php
	}?></td>
</tr>
<tr>
	<td colspan=2><input type=\"submit\" value=\"Зарегистрироваться\"></td>
</tr></table>
</form>
<?php
	}
}
?>";
	return $s;
}
?><?php
function makeViewTreeCRUDclassFO($project, $pid, $tables){
	$crud=$project[$pid];
	$parent=$project[$crud['parent']];
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$childView='';
	$s="<?php
class ".$viewName."View{
	var \$db$mainTable[name];
	var \$list$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="var \$filter;
	var \$filter_check;
	var \$parent;
	var \$where='';
	var \$page=1;
	var \$limit=0;
	var \$order='';
	var \$cnt;
	var \$childView='';
	
	function ".$viewName."View(){
		//инициализация конфигурации
		if(!isset(\$_SESSION['$viewName'])){
			\$_SESSION['$viewName']['filter']=array();
			\$_SESSION['$viewName']['filter_check']=array();
			\$_SESSION['$viewName']['page']=1;
			\$_SESSION['$viewName']['limit']=100;
			\$_SESSION['$viewName']['order']='';
		}
		//собираем входные данные
		if(isset(\$_REQUEST['filter']) && is_array(\$_REQUEST['filter'])){
			\$_SESSION['$viewName']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			\$_SESSION['$viewName']['datafields']=array();
";
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$s.="\$_SESSION['$viewName']['filter']['id'] = mysql_escape_string(\$_REQUEST['filter']['id']);//*
\$_SESSION['$viewName']['filter_check']['id'] = \$_REQUEST['filter_check']['id'] == 'on';
";
			}else{
				$type=$mainTable['fields'][$fname]['type'];
				if($type=='date'){
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_from'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_from']);
\$_SESSION['$viewName']['filter_check']['$fname"."_from'] = \$_REQUEST['filter_check']['$fname"."_from'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_from']='from';
";
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_to'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_to']);
\$_SESSION['$viewName']['filter_check']['$fname"."_to'] = \$_REQUEST['filter_check']['$fname"."_to'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_to']='to';
";
					$s.="";
				}else{
					$s.="\$_SESSION['$viewName']['datafields']['$fname']='$type';
\$_SESSION['$viewName']['filter']['$fname'] = mysql_escape_string(\$_REQUEST['filter']['$fname']);
\$_SESSION['$viewName']['filter_check']['$fname'] = \$_REQUEST['filter_check']['$fname'] == 'on';
";
				}
			}
		}
	}
			$s.="
		}
		if(isset(\$_REQUEST['start'])){\$_SESSION['$viewName']['page']=\$_REQUEST['page']*1;}
		if(isset(\$_REQUEST['limit'])){\$_SESSION['$viewName']['limit']=\$_REQUEST['limit']*1;}
		if(isset(\$_REQUEST['order'])){
			\$_SESSION['$viewName']['order'] = mysql_escape_string(\$_REQUEST['order']);
		}
		if(isset(\$_REQUEST['filter_id'])){
			\$_SESSION['$viewName']['filter']=array(\"id\"=>\$_REQUEST['filter_id']*1);
		}
		
		\$this->filter=\$_SESSION['$viewName']['filter'];
		\$this->filter_check=\$_SESSION['$viewName']['filter_check'];
		\$this->start=\$_SESSION['$viewName']['page'];
		\$this->limit=\$_SESSION['$viewName']['limit'];
		\$this->order=\$_SESSION['$viewName']['order'];
		//создаём объекты доступа к таблицам
		\$this->db$mainTable[name]=new db$mainTable[name]();
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
		if(isset(\$_REQUEST['parent'])){
			\$this->parent=\$_REQUEST['parent']*1;
			\$_SESSION['$viewName']['parent']=\$this->parent;
		}else{
			if(isset(\$_SESSION['$viewName']['parent'])){
				\$this->parent=\$_SESSION['$viewName']['parent'];
			}else{
				\$this->parent=0;
			}
		}
		//создать из \$filter => \$where
		\$this->where=\" `".$crud['content']['parent_key']."`='\$this->parent'\";
		\$d=' AND';
		if(is_array(\$this->filter)){
			foreach (\$this->filter as \$fid => \$fval){
				if(\$this->filter_check[\$fid]){
					if(\$_SESSION['$viewName']['datafields'][\$fid]=='from'){
						\$p0=strpos(\$fid,'_from');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`>='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='to'){
						\$p0=strpos(\$fid,'_to');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`<='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='string'){
						\$this->where.=\$d.\"`\$fid` LIKE '\$fval'\";
					}else{
						\$this->where.=\$d.\"`\$fid`='\$fval'\";
					}
					\$d=' AND ';
				}
			}
		}
		\$this->cnt = \$this->db$mainTable[name]->count(\$this->where);
		
		//получаем основной лист
		\$start=(\$this->page - 1) * \$this->limit;
		\$this->list$mainTable[name]=\$this->db$mainTable[name]->load(\$this->where, \$this->order, \$start, \$this->limit);
		";
		//определяем наличие потомка
		if($crud['content']['thistable']!=null && $crud['content']['childtable']!=null){
			$s.="//есть потомок
";
			//ищем потомка
			foreach ($project as $lpid => $element){
				if($element['parent']==$pid){
					$childView=translit($element['name']);
					$s.="\$this->childView='".$childView."';
";
				}
			}
		}
		$s.="
	}
	
	function Paint(){
		echo(\$this->parentLine().'<br>');
		?>
";
		//проверить, кто parent
		if($parent['type']=='CRUD' || $parent['type']=='TreeCRUD'){
			$s.="<a href='?view=".translit( $parent['name'] )."View'>&lt;&lt;&lt;&lt; Назад</br>";
		}
		$s.="
<form action='?view=$viewName"."View' method=post>
<table border=1><tr>";
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			$s.="
<td>";
			switch ($type){
				case 'on_off':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=checkbox name='filter[$fname]' value='on' <?php if(\$this->filter['$fname']!=0){?> checked<?php }?>'>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUpList(\$this->list$lookUpTable[name], \$this->filter['$fname'], '$field[lookupfield]', 'filter[$fname]'));?>";
					}else{
						$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
					}
				break;
				case 'string':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'date':
					$s.="<input type='checkbox' name='filter_check[$fname"."_from]' <?php if(\$this->filter_check['$fname"."_from']){ echo(\" checked\");}?> value='on'>$fname"."_from:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_from_fd' name='filter[$fname"."_from]' value='<?php echo(\$this->filter['$fname"."_from']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_from_fd', 'datetime', 'filter_$fname"."_from_fd');\"><br>";
					$s.="<input type='checkbox' name='filter_check[$fname"."_to]' <?php if(\$this->filter_check['$fname"."_to']){ echo(\" checked\");}?> value='on'>$fname"."_to:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_to_fd' name='filter[$fname"."_to]' value='<?php echo(\$this->filter['$fname"."_to']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_to_fd', 'datetime', 'filter_$fname"."_to_fd');\">";
				break;
				case 'text':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'file':
					$s.="";
				break;
			}
$s.="</td>";
		}
	}
$s.="</tr></table>
<input type='submit' value='Фильтр'>
</form>
<br>
<a href='?view=$viewName"."View&action=add$viewName"."Action";
		$s.="<?php if(\$this->parent!=0){
		echo \"&".$crud['content']['parent_key']."=\$this->parent\"; } ?>";
		$s.="'>Add</a><br>
Страница:  <?php \$this->shkala(); ?>
<table border=\"1\">
<tr>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
<td>$fname</td>";
		}
	}
	$s.="
<td></td>
<td></td>
<td></td>";
	if($childView!=''){
		$s.="
<td></td>";
	}
	$s.="
</tr>
<?php
		foreach (\$this->list$mainTable[name] as \$i => \$onerec){
			?><tr>";
	//foreach ($mainTable['fields'] as $fname => $field){
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
	<td>";
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			switch ($type){
				case 'on_off':
					$s.="<?php if(\$onerec['$fname']!=0){?>ON<?php }else{?>OFF<?php }?>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$onerec['$fname'], '$field[lookupfield]'));?>";
					}else{
						$s.="<?php echo(\$onerec['$fname']);?>";
					}
				break;
				case 'string':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'date':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'text':
					$s.="<?php echo(\$this->longText(\$onerec['$fname']));?>";
				break;
				case 'file':
					$s.="<?php echo(\$this->photo(\$onerec['id'], '$fname'));?>";
				break;
			}
			$s.="</td>";
		}
	}
			$s.="
	<td><a href='?view=$viewName"."View&parent=<?=\$onerec['id']?>'>Node</a></td>
	<td><a href='?view=$viewName"."Edit&id=<?=\$onerec['id']?>'>Edit</a></td>
	<td><a href='?view=$viewName"."View&action=del$viewName"."Action&id=<?=\$onerec['id']?>'>Del</a></td>
	";
	if($childView!=''){
		$s.="
<td><a href='?view=$childView"."View&filter_check[".$crud['content']['childtable']."]=on&filter[".$crud['content']['childtable']."]=<?=\$onerec['".$crud['content']['thistable']."']?>'>Next</a></td>";
	}
	$s.="
</tr><?php
		}
?>
</table>
		<?php
		\$this->shkala();
	}
	function parentLine(){
		\$s='';
		\$parent=\$this->parent;
		\$d='';
		while(\$parent!=0){
			\$rec=\$this->db$mainTable[name]->get(\$parent);
			\$parent=\$rec['".$crud['content']['parent_key']."'];
			\$s='<a href=\"?view=$viewName"."View&parent='.\$rec['id'].'\">'.\$rec['".$crud['content']['indicator_key']."'].'</a>'.\$d.\$s;
			\$d=' / ';
		}
		\$s='<a href=\"?view=$viewName"."View&parent=0\">All</a>'.\$d.\$s;
		return \$s;
	}
	function lookUp(&\$list, \$id, \$field_name){
		\$res=false;
		\$fna=explode(\":\",\$field_name);
		foreach (\$list as \$rec){
			if(\$rec['id']==\$id){
				\$res='';
				foreach (\$fna as \$ofn){
					\$res.=\$rec[\$ofn].' ';
				}
			}
		}
		return \$res;
	}
	function lookUpList(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\".\$rec['id'].\"'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.=\">\";
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function longText(\$s, \$len=50){
		if(strlen(\$s)>\$len){
			return substr(\$s,0,\$len).'...';
		}else{
			return \$s;
		}
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
	function shkala(){
		\$cnt=round(\$this->cnt / \$this->limit + 0.5);
		for(\$i=0;\$i<\$cnt;\$i++){
			if(\$i>0){
				?> | <?php
			}
			if(\$i+1==\$this->page){
				echo (\$i+1);
			}else{
				?><a href='?view=$viewName"."View&page=<?php echo(\$i);?>'><?php echo (\$i+1);?></a><?php
			}
		}
	}
}
?>";
	return $s;
}
?><?php
function makeViewTreeCRUDclass($project, $pid, $tables){
	$crud=$project[$pid];
	$parent=$project[$crud['parent']];
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$childView='';
	$s="<?php
class ".$viewName."ViewBO{
	var \$db$mainTable[name];
	var \$list$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="var \$filter;
	var \$filter_check;
	var \$parent;
	var \$where='';
	var \$page=1;
	var \$limit=0;
	var \$order='';
	var \$cnt;
	var \$childView='';
	
	function ".$viewName."ViewBO(){
		//инициализация конфигурации
		if(!isset(\$_SESSION['$viewName'])){
			\$_SESSION['$viewName']['filter']=array();
			\$_SESSION['$viewName']['filter_check']=array();
			\$_SESSION['$viewName']['page']=1;
			\$_SESSION['$viewName']['limit']=100;
			\$_SESSION['$viewName']['order']='';
		}
		//собираем входные данные
		if(isset(\$_REQUEST['filter']) && is_array(\$_REQUEST['filter'])){
			\$_SESSION['$viewName']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			\$_SESSION['$viewName']['datafields']=array();
";
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$s.="\$_SESSION['$viewName']['filter']['id'] = mysql_escape_string(\$_REQUEST['filter']['id']);//*
\$_SESSION['$viewName']['filter_check']['id'] = \$_REQUEST['filter_check']['id'] == 'on';
";
			}else{
				$type=$mainTable['fields'][$fname]['type'];
				if($type=='date'){
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_from'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_from']);
\$_SESSION['$viewName']['filter_check']['$fname"."_from'] = \$_REQUEST['filter_check']['$fname"."_from'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_from']='from';
";
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_to'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_to']);
\$_SESSION['$viewName']['filter_check']['$fname"."_to'] = \$_REQUEST['filter_check']['$fname"."_to'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_to']='to';
";
					$s.="";
				}else{
					$s.="\$_SESSION['$viewName']['datafields']['$fname']='$type';
\$_SESSION['$viewName']['filter']['$fname'] = mysql_escape_string(\$_REQUEST['filter']['$fname']);
\$_SESSION['$viewName']['filter_check']['$fname'] = \$_REQUEST['filter_check']['$fname'] == 'on';
";
				}
			}
		}
	}
			$s.="
		}
		if(isset(\$_REQUEST['start'])){\$_SESSION['$viewName']['page']=\$_REQUEST['page']*1;}
		if(isset(\$_REQUEST['limit'])){\$_SESSION['$viewName']['limit']=\$_REQUEST['limit']*1;}
		if(isset(\$_REQUEST['order'])){
			\$_SESSION['$viewName']['order'] = mysql_escape_string(\$_REQUEST['order']);
		}
		if(isset(\$_REQUEST['filter_id'])){
			\$_SESSION['$viewName']['filter']=array(\"id\"=>\$_REQUEST['filter_id']*1);
		}
		
		\$this->filter=\$_SESSION['$viewName']['filter'];
		\$this->filter_check=\$_SESSION['$viewName']['filter_check'];
		\$this->start=\$_SESSION['$viewName']['page'];
		\$this->limit=\$_SESSION['$viewName']['limit'];
		\$this->order=\$_SESSION['$viewName']['order'];
		//создаём объекты доступа к таблицам
		\$this->db$mainTable[name]=new db$mainTable[name]();
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
		if(isset(\$_REQUEST['parent'])){
			\$this->parent=\$_REQUEST['parent']*1;
			\$_SESSION['$viewName']['parent']=\$this->parent;
		}else{
			if(isset(\$_SESSION['$viewName']['parent'])){
				\$this->parent=\$_SESSION['$viewName']['parent'];
			}else{
				\$this->parent=0;
			}
		}
		//создать из \$filter => \$where
		\$this->where=\" `".$crud['content']['parent_key']."`='\$this->parent'\";
		\$d=' AND';
		if(is_array(\$this->filter)){
			foreach (\$this->filter as \$fid => \$fval){
				if(\$this->filter_check[\$fid]){
					if(\$_SESSION['$viewName']['datafields'][\$fid]=='from'){
						\$p0=strpos(\$fid,'_from');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`>='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='to'){
						\$p0=strpos(\$fid,'_to');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`<='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='string'){
						\$this->where.=\$d.\"`\$fid` LIKE '\$fval'\";
					}else{
						\$this->where.=\$d.\"`\$fid`='\$fval'\";
					}
					\$d=' AND ';
				}
			}
		}
		\$this->cnt = \$this->db$mainTable[name]->count(\$this->where);
		
		//получаем основной лист
		\$start=(\$this->page - 1) * \$this->limit;
		\$this->list$mainTable[name]=\$this->db$mainTable[name]->load(\$this->where, \$this->order, \$start, \$this->limit);
		";
		//определяем наличие потомка
		if($crud['content']['thistable']!=null && $crud['content']['childtable']!=null){
			$s.="//есть потомок
";
			//ищем потомка
			foreach ($project as $lpid => $element){
				if($element['parent']==$pid){
					$childView=translit($element['name']);
					$s.="\$this->childView='".$childView."';
";
				}
			}
		}
		$s.="
	}
	
	function Paint(){
		echo(\$this->parentLine().'<br>');
		?>
";
		//проверить, кто parent
		if($parent['type']=='CRUD' || $parent['type']=='TreeCRUD'){
			$s.="<a href='?view=".translit( $parent['name'] )."ViewBO'>&lt;&lt;&lt;&lt; Назад</br>";
		}
		$s.="
<form action='?view=$viewName"."ViewBO' method=post>
<input type='submit' value='Фильтр'>
<table border=1><tr>";
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			$s.="
<td>";
			switch ($type){
				case 'on_off':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=checkbox name='filter[$fname]' value='on' <?php if(\$this->filter['$fname']!=0){?> checked<?php }?>'>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUpList(\$this->list$lookUpTable[name], \$this->filter['$fname'], '$field[lookupfield]', 'filter[$fname]'));?>";
					}else{
						$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
					}
				break;
				case 'string':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'date':
					$s.="<input type='checkbox' name='filter_check[$fname"."_from]' <?php if(\$this->filter_check['$fname"."_from']){ echo(\" checked\");}?> value='on'>$fname"."_from:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_from_fd' name='filter[$fname"."_from]' value='<?php echo(\$this->filter['$fname"."_from']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_from_fd', 'datetime', 'filter_$fname"."_from_fd');\"><br>";
					$s.="<input type='checkbox' name='filter_check[$fname"."_to]' <?php if(\$this->filter_check['$fname"."_to']){ echo(\" checked\");}?> value='on'>$fname"."_to:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_to_fd' name='filter[$fname"."_to]' value='<?php echo(\$this->filter['$fname"."_to']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_to_fd', 'datetime', 'filter_$fname"."_to_fd');\">";
				break;
				case 'text':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'file':
					$s.="";
				break;
			}
$s.="</td>";
		}
	}
$s.="</tr></table>
</form>
<br>
<a href='?view=$viewName"."ViewBO&action=add$viewName"."ActionBO";
		$s.="<?php if(\$this->parent!=0){
		echo \"&".$crud['content']['parent_key']."=\$this->parent\"; } ?>";
		$s.="'>Add</a><br>
Страница:  <?php \$this->shkala(); ?>
<table border=\"1\">
<tr>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
<td>$fname</td>";
		}
	}
	$s.="
<td></td>
<td></td>
<td></td>";
	if($childView!=''){
		$s.="
<td></td>";
	}
	$s.="
</tr>
<?php
		foreach (\$this->list$mainTable[name] as \$i => \$onerec){
			?><tr>";
	//foreach ($mainTable['fields'] as $fname => $field){
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
	<td>";
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			switch ($type){
				case 'on_off':
					$s.="<?php if(\$onerec['$fname']!=0){?>ON<?php }else{?>OFF<?php }?>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$onerec['$fname'], '$field[lookupfield]'));?>";
					}else{
						$s.="<?php echo(\$onerec['$fname']);?>";
					}
				break;
				case 'string':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'date':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'text':
					$s.="<?php echo(\$this->longText(\$onerec['$fname']));?>";
				break;
				case 'file':
					$s.="<?php echo(\$this->photo(\$onerec['id'], '$fname'));?>";
				break;
			}
			$s.="</td>";
		}
	}
			$s.="
	<td><a href='?view=$viewName"."ViewBO&parent=<?=\$onerec['id']?>'>Node</a></td>
	<td><a href='?view=$viewName"."EditBO&id=<?=\$onerec['id']?>'>Edit</a></td>
	<td><a href='?view=$viewName"."ViewBO&action=del$viewName"."ActionBO&id=<?=\$onerec['id']?>'>Del</a></td>
	";
	if($childView!=''){
		$s.="
<td><a href='?view=$childView"."ViewBO&filter_check[".$crud['content']['childtable']."]=on&filter[".$crud['content']['childtable']."]=<?=\$onerec['".$crud['content']['thistable']."']?>'>Next</a></td>";
	}
	$s.="
</tr><?php
		}
?>
</table>
		<?php
		\$this->shkala();
	}
	function parentLine(){
		\$s='';
		\$parent=\$this->parent;
		\$d='';
		while(\$parent!=0){
			\$rec=\$this->db$mainTable[name]->get(\$parent);
			\$parent=\$rec['".$crud['content']['parent_key']."'];
			\$s='<a href=\"?view=$viewName"."ViewBO&parent='.\$rec['id'].'\">'.\$rec['".$crud['content']['indicator_key']."'].'</a>'.\$d.\$s;
			\$d=' / ';
		}
		\$s='<a href=\"?view=$viewName"."ViewBO&parent=0\">All</a>'.\$d.\$s;
		return \$s;
	}
	function lookUp(&\$list, \$id, \$field_name){
		\$res=false;
		\$fna=explode(\":\",\$field_name);
		foreach (\$list as \$rec){
			if(\$rec['id']==\$id){
				\$res='';
				foreach (\$fna as \$ofn){
					\$res.=\$rec[\$ofn].' ';
				}
			}
		}
		return \$res;
	}
	function lookUpList(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\".\$rec['id'].\"'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.=\">\";
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function longText(\$s, \$len=50){
		if(strlen(\$s)>\$len){
			return substr(\$s,0,\$len).'...';
		}else{
			return \$s;
		}
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
	function shkala(){
		\$cnt=round(\$this->cnt / \$this->limit + 0.5);
		for(\$i=0;\$i<\$cnt;\$i++){
			if(\$i>0){
				?> | <?php
			}
			if(\$i+1==\$this->page){
				echo (\$i+1);
			}else{
				?><a href='?view=$viewName"."ViewBO&page=<?php echo(\$i);?>'><?php echo (\$i+1);?></a><?php
			}
		}
	}
}
?>";
	return $s;
}
?><?php
class CRUD{
	var $filter;
	var $page;
	var $limit;
	
	function CRUD(){
		
	}
	function Paint(){}
}
?><?php
require_once('Models//*table*/.class.php');
class /*table*/View{
	var $page=0;
	var $limit=10;
	//fields
	function /*table*/View(){
		//fields verify
		if(isset($_REQUEST['page'])){
			$this->page=$_REQUEST['page']*1;$_SESSION['/*table*/ViewPage']=$this->page;
		}else{
			if(isset($_SESSION['/*table*/ViewPage'])){$this->page=$_SESSION['/*table*/ViewPage'];}
		}
		if(isset($_REQUEST['limit'])){
			$this->limit=$_REQUEST['limit']*1;$_SESSION['/*table*/ViewLimit']=$this->limit;
		}else{
			if(isset($_SESSION['/*table*/ViewLimit'])){$this->limit=$_SESSION['/*table*/ViewLimit'];}
		}
	}
	function Paint(){
		$db=new /*table*/Model;
		//линейку страниц
		$cnt=$db->count();
		$pages=round($cnt/$this->limit + 0.5);
		?>Страница: <?php
		for($i=1;$i<=$pages;$i++){
			?><a href='?view=/*table*/View&page=<?=$i?>'></a><?php
		}
		?><br><?php
		//страницу
		$list=array();
		$db->load($list,'','',($this->page - 1)*$this->limit, $this->limit);
		?>
		<table border="1">
		<tr>
			//fields title
		</tr>
		<?php
		foreach ($list as $i => $record){
			foreach ($record as $field => $value){
				?><td><?=$value?></td><?php
			}
		}
		?>
		</table>
		<?php
	}
}
?><?php
function makeAddCRUDclass($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class add".$viewName."ActionBO{
	function Go(){
		\$db$mainTable[name]=new db$mainTable[name]();
";
	
		//если есть какие-то фильтры, то надо указывать данные из этих фильтров
		foreach ($mainTable['fields'] as $field_name => $field){
			$s.="if(\$_SESSION['$viewName']['filter_check']['$field_name']=='on'){
	\$$field_name=\$_SESSION['$viewName']['filter']['$field_name'];
}else{
	\$$field_name=";
			if($field['type']=='string' || $field['type']=='text'){
				$s.="''";
			}else{
				$s.='0';
			}
			$s.=";
}
";
			if($crud['type']=='TreeCRUD'){
				if($field_name==$crud['content']['parent_key']){
					$s.="\$$field_name=mysql_escape_string(\$$field_name);
";
				}
			}
		}
		
		if($crud['type']=='TreeCRUD'){
		$s.="\$".$crud['content']['parent_key']."=\$_REQUEST['".$crud['content']['parent_key']."'];
";
	}

		$s.="\$db$mainTable[name]->add(";
		$d='';
		foreach ($mainTable['fields'] as $field_name => $field){
			$s.=$d." \$$field_name";
			/*
			if($crud['type']=='TreeCRUD'){
				if($field['type']=='string' || $field['type']=='text'){
					if($field_name==$crud['content']['parent_key']){
						$s.="mysql_escape_string(\$$field_name)";
					}else{
						$s.="''";
					}
				}else{
					if($field_name==$crud['content']['parent_key']){
						$s.="\$$field_name*1";
					}else{
						$s.="0";
					}
				}
			}else{
				if($field['type']=='string' || $field['type']=='text'){
					$s.="''";
					
					
					
				}else{
					$s.="0";
				}
			}
			*/
			$d=', ';
		}
		$s.=");
	}
}
?>";
	return $s;
}
?><?php
function makeDelCRUDclassFO($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class del".$viewName."Action{
	function Go(){
		\$db$mainTable[name]=new db$mainTable[name]();
		\$db$mainTable[name]->del(\$_REQUEST['id']*1);
	}
}
?>";
	return $s;
}
?><?php
function makeDelCRUDclass($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class del".$viewName."ActionBO{
	function Go(){
		\$db$mainTable[name]=new db$mainTable[name]();
		\$db$mainTable[name]->del(\$_REQUEST['id']*1);
	}
}
?>";
	return $s;
}
?><?php
function makeActionRegistrBO($tables){
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	$s="<?php
class registrFormActionBO{
	function Go(){
		if(isset(\$_REQUEST['login']) &&
		isset(\$_REQUEST['password']) &&
		isset(\$_REQUEST['password2']) &&
		isset(\$_REQUEST['email'])){
			\$login=mysql_escape_string(\$_REQUEST['login']);
			\$password=mysql_escape_string(\$_REQUEST['password']);
			\$password2=mysql_escape_string(\$_REQUEST['password2']);
			";
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){		
	$s.="\$$fname=mysql_escape_string(\$_REQUEST['$fname']);
\$_SESSION['registr']['$fname']=\$$fname;
";
		}
	}
		$s.="\$capche=\$_REQUEST['capche'];
			
			\$_SESSION['registr']['login']=\$login;
			if(\$capche!=\$_SESSION['S_CAPCHE']){
				//ошибка capche
				\$_SESSION['registr']['error']='capche error';
				header('location: ?view=registrFormViewBO');
			}
			if(\$password==\$password2){
				\$right=0;
				\$dbuser=new dbuser();
				\$dbuser->add(";
		$d='';
		foreach ($table['fields'] as $fname => $field){
			$s.=$d.'$'.$fname;
			$d=', ';
		}
		$s.=");
			}else{
				//некорректный пароль
				\$_SESSION['registr']['error']='password error';
				header('location: ?view=registrFormViewBO');
			}
		}
	}
}
?>";
	return $s;
}
?><?php
function makeActionRegistrFO($tables){
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	$s="<?php
class registrFormAction{
	function Go(){
		if(isset(\$_REQUEST['login']) &&
		isset(\$_REQUEST['password']) &&
		isset(\$_REQUEST['password2']) &&
		isset(\$_REQUEST['email'])){
			\$login=mysql_escape_string(\$_REQUEST['login']);
			\$password=mysql_escape_string(\$_REQUEST['password']);
			\$password2=mysql_escape_string(\$_REQUEST['password2']);
			";
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){		
	$s.="\$$fname=mysql_escape_string(\$_REQUEST['$fname']);
\$_SESSION['registr']['$fname']=\$$fname;
";
		}
	}
		$s.="\$capche=\$_REQUEST['capche'];
			
			\$_SESSION['registr']['login']=\$login;
			if(\$capche!=\$_SESSION['S_CAPCHE']){
				//ошибка capche
				\$_SESSION['registr']['error']='capche error';
				header('location: ?view=registrFormView');
			}
			if(\$password==\$password2){
				\$right=0;
				\$dbfront_user=new dbfront_user();
				\$dbfront_user->add(\$email, \$password, \$right, \$login, '', '', '', date('Y-m-d H:i:s'), 0, 0, 0);
			}else{
				//некорректный пароль
				\$_SESSION['registr']['error']='password error';
				header('location: ?view=registrFormView');
			}
		}
	}
}
?>";
	return $s;
}
?><?php
function makeUpdateCRUDclassFO($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class update".$viewName."Action{
	function Go(){
		\$id=\$_REQUEST['id']*1;
		\$db$mainTable[name]=new db$mainTable[name]();
		//новые поля
		";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$type=$mainTable['fields'][$fname]['type'];
			if($type=='file'){
				$s.="if(isset(\$_FILES['$fname']) && \$_FILES['$fname']['tmp_name']!=''){
			\$path=photoPath(\$id).'/$fname';
			copy(\$_FILES['$fname']['tmp_name'], \$path);
		}";
			}
		}
	}
		$s.="
		\$db$mainTable[name]->update(\$id";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$type=$mainTable['fields'][$fname]['type'];
			switch ($type){
				case 'int':
				case 'on_off':
					$s.=", (\$_REQUEST['$fname']*1)";
				break;
				case 'string':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'date':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'text':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'file':
					$s.=", \$id";
				break;
			}
		}else{
			if($fname!='ID'){
				$s.=", null";
			}
		}
	}
		$s.=");
	}
}
?>";
	return $s;
}
?><?php
function makeUpdateCRUDclass($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class update".$viewName."ActionBO{
	function Go(){
		\$id=\$_REQUEST['id']*1;
		\$db$mainTable[name]=new db$mainTable[name]();
		//новые поля
		";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$type=$mainTable['fields'][$fname]['type'];
			if($type=='file'){
				$s.="if(isset(\$_FILES['$fname']) && \$_FILES['$fname']['tmp_name']!=''){
			\$path=photoPath(\$id).'/$fname';
			copy(\$_FILES['$fname']['tmp_name'], \$path);
		}";
			}
		}
	}
		$s.="
		\$db$mainTable[name]->update(\$id";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$type=$mainTable['fields'][$fname]['type'];
			switch ($type){
				case 'int':
				case 'on_off':
					$s.=", (\$_REQUEST['$fname']*1)";
				break;
				case 'string':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'date':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'text':
					//mysql_escape_string
					$s.=", mysql_escape_string(\$_REQUEST['$fname'])";
				break;
				case 'file':
					$s.=", \$id";
				break;
			}
		}else{
			if($fname!='ID'){
				$s.=", null";
			}
		}
	}
		$s.=");
	}
}
?>";
	return $s;
}
?><?php
function checkAuthBO($user_id, $module_name){
	//ищем такого юзера
	$sql="SELECT * FROM user WHERE id=".($user_id*1);
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
	$sql="SELECT * FROM modules WHERE module='$module_name'";
	$r=mysql_query($sql);
	$n=mysql_num_rows($r);
	if($n>0){
		$module=mysql_result($r,0,'id');
		//ищем такой модуль с правами такого юзера
		$sql="SELECT count(*) as cnt FROM cross_right WHERE (`right`=$right OR `right`=0) AND module=$module";
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

function loginBO($login, $password){
	$sql="SELECT * FROM user WHERE login='".mysql_escape_string($login)."' AND password='".mysql_escape_string($password)."'";
	$r=mysql_query($sql);
	$n=mysql_num_rows($r);
	if($n>0){
		$_SESSION['user_id']=mysql_result($r,0,'id');
	}
}
function logOutBO(){
	unset($_SESSION['user_id']);
}
?><?php
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
?><?php
session_start();
require_once('connect_db.php');
require_once('authBO.php');
require_once('lib.php');
requireDir('Models/');
requireDir('ViewBO/');
requireDir('ActionBO/');

//проверяем попытку авторизации
if(isset($_REQUEST['login']) && isset($_REQUEST['password'])){
	loginBO($_REQUEST['login'], $_REQUEST['password']);
}

$menu = new menuBO();

if(isset($_REQUEST['action'])){
	//проверит авторизацию
	if(checkAuthBO($_SESSION['user_id'], $_REQUEST['action'])){
		eval("\$action=new $_REQUEST[action]();");
		$action->Go();
	}
}
if(isset($_REQUEST['view'])){
	//проверит авторизацию
	if(checkAuthBO($_SESSION['user_id'], $_REQUEST['view'])){
		eval("\$view=new $_REQUEST[view]();");
	}
}else{
	$view=null;
}
?>
<html>
<head>
<title>Tarion</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="tbl_change.js"></script>
<?php $menu->Paint();?>
<td align="right">
<input type="button" onclick="document.getElementById('authTable').style.display='block';" value="Авторизация">
</td>
</tr>
</table>
<table id='authTable' style="position:absolute;top:300px;left:300px;width:150px;background-color:Aqua;display:none;">
<form method="POST" action="">
<tr><td>login:</td><td><input type="text" name="login" style="width:80px;height:18px;"></td></tr>
<tr><td>password:</td><td><input type="password" name="password" style="width:80px;height:18px;"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Вход" style="height:18px;"></td></tr>
<tr><td colspan="2" align="center"><a href="?view=registrFormView">Регистрация</a></td></tr>
</form>
</table>
<script>
document.getElementById('authTable').style.left=Math.round(document.body.clientWidth/2 - 150/2);
</script>

<br>
<table width="100%" border="1">
<tr></tr>
	<td valign="top"><?php if($view!=null){$view->Paint();}?></td>
</tr>
</table>
</body>
</html><html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-81" />
	<title>Календарь</title>
	<meta name="robots" content="noindex,nofollow" />
</head>
<body>
<style>
/* general tags */
html {
    font-size: 82%;
}

input, select, textarea {
    font-size: 1em;
}

body {
    font-family:        sans-serif;
    padding:            0;
    margin:             0.5em;
    color:              #000000;
    background:         #F5F5F5;
}

textarea, tt, pre, code {
    font-family:        monospace;
}
h1 {
    font-size:          140%;
    font-weight:        bold;
}

h2 {
    font-size:          120%;
    font-weight:        bold;
}

h3 {
    font-weight:        bold;
}

a:link,
a:visited,
a:active {
    text-decoration:    none;
    color:              #0000FF;
}

a:hover {
    text-decoration:    underline;
    color:              #FF0000;
}

dfn {
    font-style:         normal;
}

dfn:hover {
    font-style:         normal;
    cursor:             help;
}

th {
    font-weight:        bold;
    color:              #000000;
    background:         #D3DCE3;
}

a img {
    border:             0;
}

hr {
    color:              #000000;
    background-color:   #000000;
    border:             0;
    height:             1px;
}

form {
    padding:            0;
    margin:             0;
    display:            inline;
}

textarea {
    overflow:           visible;
    height:             9em;
}

fieldset {
    margin-top:         1em;
    border:             #000000 solid 1px;
    padding:            0.5em;
    background:         #E5E5E5;
}

fieldset fieldset {
    margin:             0.8em;
}

fieldset legend {
    font-weight:        bold;
    color:              #444444;
    background-color:   transparent;
}

/* buttons in some browsers (eg. Konqueror) are block elements,
   this breaks design */
button {
    display:            inline;
}

table caption,
table th,
table td {
    padding:            0.1em 0.5em 0.1em 0.5em;
    margin:             0.1em;
    vertical-align:     top;
}

img,
input,
select,
button {
    vertical-align:     middle;
}
/* Calendar */
table.calendar {
    width:              100%;
}
table.calendar td {
    text-align:         center;
}
table.calendar td a {
    display:            block;
}

table.calendar td a:hover {
    background-color:   #CCFFCC;
}

table.calendar th {
    background-color:   #D3DCE3;
}

table.calendar td.selected {
    background-color:   #FFCC99;
}

img.calendar {
    border:             none;
}
form.clock {
    text-align:         center;
}
/* end Calendar */
</style>
<script src="tbl_change.js"></script>
<script>
var month_names = new Array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
var day_names = new Array("Пн","Вт","Ср","Чт","Пт","Сб","Вс");
var submit_text = " Время ";
</script>
</head>
<body onload="initCalendar();">
<div id="calendar_data"></div>
<div id="clock_data"></div>
</body>
</html>
<?php
session_start();
Header("Content-type: image/gif");


$capche_img=imagecreate(100,20);

$white = ImageColorAllocate($capche_img, 255,255,255);
$black = ImageColorAllocate($capche_img, 0,0,0);


$r=imagefilledrectangle($capche_img, 0, 0, 70, 20, $white); 
$smb = '0987654321abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
if(!isset($_SESSION['S_CAPCHE'])){session_register('S_CAPCHE');}
$_SESSION['S_CAPCHE']='';
for($i=0;$i<7;$i++){
	$_SESSION['S_CAPCHE'].=$smb[rand(0,strlen($smb)-1)];
}
$pos = array(0,1,2,3,4,5);
$x=2;
for($i=0;$i<strlen($_SESSION['S_CAPCHE']);$i++){
	$s=$_SESSION['S_CAPCHE'][$i];
	$y=$pos[rand(0,5)];
	$r=imagestring($capche_img, 5, $x, $y, $s, $black);
	$x+=9;
}
$r=imagegif($capche_img); 
?><?php
class menuBO{
	var $menuTree;
	function Paint(){
		$this->menuTree=unserialize('/*menu*/');
		$this->TreePaint(0,0);
	}
	function TreePaint($parent,$level){
		$i=0;
		$j=0;
		$node=array();
		foreach($this->menuTree as $i => $punkt){
			if($punkt['parent']==$parent){
				$node[$j]=$punkt;
				$j++;
			}
		}
		$max=$j-1;
		foreach($node as $i => $punkt){
			if($punkt['type']=='menu'){
				if($max>0){
					?><li class='Node ExpandLeaf'><?php
				}else{
					?>"<li class='Node ExpandLeaf IsLast'><?php
				}
				$max--;
				?><div class='Expand'></div>
				<div class='Content' style='cursor:pointer;'>
				<?php
				/*
				меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
				*/
				$next=$this->checkCRUDByParent($i);
				if($next===false){
					echo $punkt['name'];
				}else{
					$link=translit($this->menuTree[$next]['name']);
					?><a href="/<?php echo $link;?>"><?php echo $punkt['name'];?></a><?php
				}
				?>
				</div>
				<ul class='Container'><?php echo $this->TreePaint($i,$level+1);?>
				</ul>
				</li><?php
			}else{
				
			}
		}
	}
	function checkCRUDByParent($parent){
		//если находится CRUD или TreeCRUD, то вернуть id элемента, иначе вернуть false
		$result=false;
		foreach ($this->menuTree as $id => $element){
			if($element['type']=='CRUD' || $element['type']=='TreeCRUD'){
				$result=$id;
			}
		}
		return $result;
	}
	function getImgByType($type){
		switch($type){
			case 'menu':
				return 'menu.gif';
			break;
			case 'CRUD':
				return 'crud.gif';
			break;
			case 'TreeCRUD':
				return 'tree_crud.gif';
			break;
		}
	}
}
?><?php
class menuBO{
	var $menuTree;
	function Paint(){
		$this->menuTree=unserialize('/*menu*/');
		$this->TreePaint(0,0);
	}
	function TreePaint($parent,$level){
		$i=0;
		$j=0;
		$node=array();
		foreach($this->menuTree as $i => $punkt){
			if($punkt['parent']==$parent){
				$node[$j]=$punkt;
				$j++;
			}
		}
		$max=$j-1;
		foreach($node as $i => $punkt){
			if($punkt['type']=='menu'){
				if($max>0){
					?><li class='Node ExpandLeaf'><?php
				}else{
					?><li class='Node ExpandLeaf IsLast'><?php
				}
				$max--;
				?><div class='Expand'></div>
				<div class='Content' style='cursor:pointer;'>
				<?php
				/*
				меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
				*/
				$next=$this->checkCRUDByParent($i);
				if($next===false){
					echo $punkt['name'];
				}else{
					$link=translit($this->menuTree[$next]['name']);
					?><a href="/<?php echo $link;?>"><?php echo $punkt['name'];?></a><?php
				}
				?>
				</div>
				<ul class='Container'><?php echo $this->TreePaint($i,$level+1);?>
				</ul>
				</li><?php
			}else{
				//ничего не делаем
			}
		}
	}
	function checkCRUDByParent($parent){
		//если находится CRUD или TreeCRUD, то вернуть id элемента, иначе вернуть false
		$result=false;
		foreach ($this->menuTree as $id => $element){
			if($element['type']=='CRUD' || $element['type']=='TreeCRUD'){
				$result=$id;
			}
		}
		return $result;
	}
	function getImgByType($type){
		switch($type){
			case 'menu':
				return 'menu.gif';
			break;
			case 'CRUD':
				return 'crud.gif';
			break;
			case 'TreeCRUD':
				return 'tree_crud.gif';
			break;
		}
	}
}
?><?php
class menuBO{
	var $menuTree;
	function Paint(){
		$sql="SELECT * FROM modules";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		$this->menuTree=array();
		for($i=0;$i<$n;$i++){
			$id=mysql_result($r,$i,'id');
			$parent=mysql_result($r,$i,'parent');
			$module=mysql_result($r,$i,'module');
			$title=mysql_result($r,$i,'title');
			$type=mysql_result($r,$i,'type');
			//проверяем права доступа
			if(checkAuthBO($_SESSION['user_id']*1,$module)){
				$this->menuTree[$id]=array("parent"=>$parent, "name"=>$title, "type"=>$type, "module"=>$module);
			}
		}
		echo $this->TreePaint(0,0);
	}
	function TreePaint($parent,$level){
		$s='';
		$i=0;
		$j=0;
		$node=array();
		foreach($this->menuTree as $id => $punkt){
			if($punkt['parent']==$parent){
				$node[$j]=array("id"=>$id, "punkt"=>$punkt);
				$j++;
			}
		}
		$max=$j-1;
		//если уровень нулевой, то пункты меню должны отображаться на горизонтальном слое,
		//статически "прижатом" к топу страницы
		if($level==0){
			$s.="<table style='position:absolute;left:0px;top:0px;width:100%' bgcolor='Aqua' border=0 cellspacing=0 cellpadding=0>
<tr>";
			foreach($node as $i => $punkt){
				if($punkt['punkt']['type']=='menu'){
					/*
					меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
					*/
					$next=$this->checkCRUDByParent($punkt['id']);
					$ts=$this->TreePaint($punkt['id'],$level+1);
					if($next===false){
						if($ts!=''){
							$s.="<td onmouseover=\"document.getElementById('mp$i').style.display='block';\" onmouseout=\"document.getElementById('mp$i').style.display='none';\" style='width:150px;'>".$punkt['punkt']['name'];
						}else{
							$s.="<td style='width:150px;'>".$punkt['punkt']['name'];
						}
					}else{
						$link=$this->menuTree[$next]['module'];
						$s.="<a href='?view=$link'>".$punkt['punkt']['name']."</a>";
					}
					if($ts!=''){
						$s.="<div id='mp$i' style='position:absolute; left:".(10+$i*150)."px;top:20px; display:none;background-color:Aqua;border:#00cccc 1px solid;'>$ts</div>";
					}
					$s.="</td>";
				}
			}
			//$s.="<td>&nbsp;</td></tr></table>";
		}else{
			foreach($node as $i => $punkt){
				if($punkt['punkt']['type']=='menu'){
					$s.="<div style='cursor:pointer; width:100%; background-color:#00ffff;' onmouseover='this.style.backgroundColor=\"#00cccc\";' onmouseout='this.style.backgroundColor=\"#00ffff\";'>";
					//
					//меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
					//
					$next=$this->checkCRUDByParent($punkt['id']);
					if($next===false){
						$s.=$punkt['punkt']['name'];
					}else{
						$link=$this->menuTree[$next]['module'];
						$s.="<a href='?view=$link'>".$punkt['punkt']['name']."</a>";
					}
					$s.="</div>
					<div>".$this->TreePaint($punkt['id'],$level+1)."</div>";
				}else{
					
				}
			}
			/*
		foreach($node as $i => $punkt){
			if($punkt['punkt']['type']=='menu'){
				if($max>0){
					?><li class='Node ExpandLeaf'><?php
				}else{
					?><li class='Node ExpandLeaf IsLast'><?php
				}
				$max--;
				?><div class='Expand'></div>
				<div class='Content' style='cursor:pointer;'>
				<?php
				
				//меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
				
				$next=$this->checkCRUDByParent($punkt['id']);
				if($next===false){
					echo $punkt['punkt']['name'];
				}else{
					$link=$this->menuTree[$next]['module'];
					?><a href="?view=<?php echo $link;?>"><?php echo $punkt['punkt']['name'];?></a><?php
				}
				?>
				</div>
				<ul class='Container'><?php echo $this->TreePaint($punkt['id'],$level+1);?>
				</ul>
				</li><?php
			}else{
				
			}*/
		}
		return $s;
	}
	function checkCRUDByParent($parent){
		//если находится CRUD или TreeCRUD, то вернуть id элемента, иначе вернуть false
		$result=false;
		foreach ($this->menuTree as $id => $element){
			if($element['parent']==$parent && ($element['type']=='CRUD' || $element['type']=='TreeCRUD')){
				$result=$id;
			}
		}
		return $result;
	}
	function getImgByType($type){
		switch($type){
			case 'menu':
				return 'menu.gif';
			break;
			case 'CRUD':
				return 'crud.gif';
			break;
			case 'TreeCRUD':
				return 'tree_crud.gif';
			break;
		}
	}
}
?><?php
class menuFO{
	var $menuTree;
	function Paint(){
		$sql="SELECT * FROM front_modules";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		$this->menuTree=array();
		for($i=0;$i<$n;$i++){
			$id=mysql_result($r,$i,'id');
			$parent=mysql_result($r,$i,'parent');
			$module=mysql_result($r,$i,'module');
			$title=mysql_result($r,$i,'title');
			$type=mysql_result($r,$i,'type');
			//проверяем права доступа
			if(checkAuthFO($_SESSION['front_user_id']*1,$module)){
				$this->menuTree[$id]=array("parent"=>$parent, "name"=>$title, "type"=>$type, "module"=>$module);
			}
		}
		echo $this->TreePaint(0,0);
	}
	function TreePaint($parent,$level){
		$s='';
		$i=0;
		$j=0;
		$node=array();
		foreach($this->menuTree as $id => $punkt){
			if($punkt['parent']==$parent){
				$node[$j]=array("id"=>$id, "punkt"=>$punkt);
				$j++;
			}
		}
		$max=$j-1;
		//если уровень нулевой, то пункты меню должны отображаться на горизонтальном слое,
		//статически "прижатом" к топу страницы
		if($level==0){
			$s.="<table style='position:absolute;left:0px;top:0px;width:100%' bgcolor='Aqua' border=0 cellspacing=0 cellpadding=0>
<tr>";
			foreach($node as $i => $punkt){
				if($punkt['punkt']['type']=='menu'){
					/*
					меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
					*/
					$next=$this->checkCRUDByParent($punkt['id']);
					$ts=$this->TreePaint($punkt['id'],$level+1);
					if($next===false){
						if($ts!=''){
							$s.="<td onmouseover=\"document.getElementById('mp$i').style.display='block';\" onmouseout=\"document.getElementById('mp$i').style.display='none';\" style='width:150px;'>".$punkt['punkt']['name'];
						}else{
							$s.="<td style='width:150px;'>".$punkt['punkt']['name'];
						}
					}else{
						$link=$this->menuTree[$next]['module'];
						$s.="<a href='?view=$link'>".$punkt['punkt']['name']."</a>";
					}
					if($ts!=''){
						$s.="<div id='mp$i' style='position:absolute; left:".(10+$i*150)."px;top:20px; display:none;background-color:Aqua;border:#00cccc 1px solid;'>$ts</div>";
					}
					$s.="</td>";
				}
			}
			//$s.="<td>&nbsp;</td></tr></table>";
		}else{
			foreach($node as $i => $punkt){
				if($punkt['punkt']['type']=='menu'){
					$s.="<div style='cursor:pointer; width:100%; background-color:#00ffff;' onmouseover='this.style.backgroundColor=\"#00cccc\";' onmouseout='this.style.backgroundColor=\"#00ffff\";'>";
					//
					//меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
					//
					$next=$this->checkCRUDByParent($punkt['id']);
					if($next===false){
						$s.=$punkt['punkt']['name'];
					}else{
						$link=$this->menuTree[$next]['module'];
						$s.="<a href='?view=$link'>".$punkt['punkt']['name']."</a>";
					}
					$s.="</div>
					<div>".$this->TreePaint($punkt['id'],$level+1)."</div>";
				}else{
					
				}
			}
			/*
			foreach($node as $i => $punkt){
				if($punkt['punkt']['type']=='menu'){
					if($max>0){
						?><li class='Node ExpandLeaf'><?php
					}else{
						?><li class='Node ExpandLeaf IsLast'><?php
					}
					$max--;
					?><div class='Expand'></div>
					<div class='Content' style='cursor:pointer;'>
					<?php
					//
					//меню должна показываться в виде ссылки, если оно ведёт на CRUD или TreeCRUD
					//
					$next=$this->checkCRUDByParent($punkt['id']);
					if($next===false){
						echo $punkt['punkt']['name'];
					}else{
						$link=$this->menuTree[$next]['module'];
						?><a href="?view=<?php echo $link;?>"><?php echo $punkt['punkt']['name'];?></a><?php
					}
					?>
					</div>
					<ul class='Container'><?php echo $this->TreePaint($punkt['id'],$level+1);?>
					</ul>
					</li><?php
				}else{
					
				}
			}
			*/
		}
		return $s;
	}
	function checkCRUDByParent($parent){
		//если находится CRUD или TreeCRUD, то вернуть id элемента, иначе вернуть false
		$result=false;
		foreach ($this->menuTree as $id => $element){
			if($element['parent']==$parent && ($element['type']=='CRUD' || $element['type']=='TreeCRUD')){
				$result=$id;
			}
		}
		return $result;
	}
	function getImgByType($type){
		switch($type){
			case 'menu':
				return 'menu.gif';
			break;
			case 'CRUD':
				return 'crud.gif';
			break;
			case 'TreeCRUD':
				return 'tree_crud.gif';
			break;
		}
	}
}
?><?php
function makeViewCRUDclassFO($project, $pid, $tables){
	$crud=$project[$pid];
	$parent=$project[$crud['parent']];
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$childView='';
	$s="<?php
class ".$viewName."View{
	var \$db$mainTable[name];
	var \$list$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="var \$filter;
	var \$filter_check;
	var \$where='';
	var \$page=1;
	var \$limit=0;
	var \$order='';
	var \$cnt;
	var \$childView='';
	
	function ".$viewName."View(){
		//инициализация конфигурации
		if(!isset(\$_SESSION['$viewName'])){
			\$_SESSION['$viewName']['filter']=array();
			\$_SESSION['$viewName']['filter_check']=array();
			\$_SESSION['$viewName']['page']=1;
			\$_SESSION['$viewName']['limit']=100;
			\$_SESSION['$viewName']['order']='';
		}
		//собираем входные данные
		if(isset(\$_REQUEST['filter']) && is_array(\$_REQUEST['filter'])){
			\$_SESSION['$viewName']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			\$_SESSION['$viewName']['datafields']=array();
";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$s.="\$_SESSION['$viewName']['filter']['id'] = mysql_escape_string(\$_REQUEST['filter']['id']);//*
\$_SESSION['$viewName']['filter_check']['id'] = \$_REQUEST['filter_check']['id'] == 'on';
";
			}else{
				$type=$mainTable['fields'][$fname]['type'];
				if($type=='date'){
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_from'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_from']);
\$_SESSION['$viewName']['filter_check']['$fname"."_from'] = \$_REQUEST['filter_check']['$fname"."_from'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_from']='from';
";
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_to'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_to']);
\$_SESSION['$viewName']['filter_check']['$fname"."_to'] = \$_REQUEST['filter_check']['$fname"."_to'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_to']='to';
";
					$s.="";
				}else{
					$s.="\$_SESSION['$viewName']['datafields']['$fname']='$type';
\$_SESSION['$viewName']['filter']['$fname'] = mysql_escape_string(\$_REQUEST['filter']['$fname']);
\$_SESSION['$viewName']['filter_check']['$fname'] = \$_REQUEST['filter_check']['$fname'] == 'on';
";
				}
			}
		}
	}
			$s.="
		}
		if(isset(\$_REQUEST['start'])){\$_SESSION['$viewName']['page']=\$_REQUEST['page']*1;}
		if(isset(\$_REQUEST['limit'])){\$_SESSION['$viewName']['limit']=\$_REQUEST['limit']*1;}
		if(isset(\$_REQUEST['order'])){
			\$_SESSION['$viewName']['order'] = mysql_escape_string(\$_REQUEST['order']);
		}
//		if(isset(\$_REQUEST['filter_id'])){
//			\$_SESSION['$viewName']['filter']=array(\"id\"=>\$_REQUEST['filter_id']*1);
//		}
		
		\$this->filter=\$_SESSION['$viewName']['filter'];
		\$this->filter_check=\$_SESSION['$viewName']['filter_check'];
		\$this->start=\$_SESSION['$viewName']['page'];
		\$this->limit=\$_SESSION['$viewName']['limit'];
		\$this->order=\$_SESSION['$viewName']['order'];
		//создаём объекты доступа к таблицам
		\$this->db$mainTable[name]=new db$mainTable[name]();
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
		//создать из \$filter => \$where
		\$this->where='';
		\$d='';
		if(is_array(\$this->filter)){
			foreach (\$this->filter as \$fid => \$fval){
				if(\$this->filter_check[\$fid]){
					if(\$_SESSION['$viewName']['datafields'][\$fid]=='from'){
						\$p0=strpos(\$fid,'_from');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`>='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='to'){
						\$p0=strpos(\$fid,'_to');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`<='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='string'){
						\$this->where.=\$d.\"`\$fid` LIKE '\$fval'\";
					}else{
						\$this->where.=\$d.\"`\$fid`='\$fval'\";
					}
					\$d=' AND ';
				}
			}
		}
		\$this->cnt = \$this->db$mainTable[name]->count(\$this->where);
		
		//получаем основной лист
		\$start=(\$this->page - 1) * \$this->limit;
		\$this->list$mainTable[name]=\$this->db$mainTable[name]->load(\$this->where, \$this->order, \$start, \$this->limit);
		";
		//определяем наличие потомка
		if($crud['content']['thistable']!=null && $crud['content']['childtable']!=null){
			$s.="//есть потомок
";
			//ищем потомка
			foreach ($project as $lpid => $element){
				if($element['parent']==$pid){
					$childView=translit($element['name']);
					$s.="\$this->childView='".$childView."';
";
				}
			}
		}
		$s.="
	}
	
	function Paint(){
		?>";
		//проверить, кто parent
		if($parent['type']=='CRUD' || $parent['type']=='TreeCRUD'){
			$s.="<a href='?view=".translit( $parent['name'] )."View'>&lt;&lt;&lt;&lt; Назад</br>";
		}
		$s.="
<form action='?view=$viewName"."View' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>";
		$col='eeeeee';
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			$s.="
<td valign=top bgcolor='#$col' nowrap>";
			if($col=='eeeeee'){$col='dddddd';}else{$col='eeeeee';}
			switch ($type){
				case 'on_off':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=checkbox name='filter[$fname]' value='on' <?php if(\$this->filter['$fname']!=0){?> checked<?php }?>'>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUpList(\$this->list$lookUpTable[name], \$this->filter['$fname'], '$field[lookupfield]', 'filter[$fname]'));?>";
					}else{
						$s.="<input class=filter type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
					}
				break;
				case 'string':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input class=filter type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'date':
					$s.="<input type='checkbox' name='filter_check[$fname"."_from]' <?php if(\$this->filter_check['$fname"."_from']){ echo(\" checked\");}?> value='on'>$fname"."_from:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_from_fd' name='filter[$fname"."_from]' value='<?php echo(\$this->filter['$fname"."_from']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_from_fd', 'datetime', 'filter_$fname"."_from_fd');\"><br>";
					$s.="<input type='checkbox' name='filter_check[$fname"."_to]' <?php if(\$this->filter_check['$fname"."_to']){ echo(\" checked\");}?> value='on'>$fname"."_to:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_to_fd' name='filter[$fname"."_to]' value='<?php echo(\$this->filter['$fname"."_to']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_to_fd', 'datetime', 'filter_$fname"."_to_fd');\">";
				break;
				case 'text':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input class=filter type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'file':
					$s.="";
				break;
			}
$s.="</td>";
		}
	}
$s.="</tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href=\"?view=$viewName"."View&action=add$viewName"."Action\"'><br>
Страница: <?php \$this->shkala(); ?>
<table border=\"0\" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
<td>$fname</td>";
		}
	}
	$s.="
<td></td>
<td></td>";
	if($childView!=''){
		$s.="
<td></td>";
	}
	$s.="
</tr>
<?php
		\$col='eeeeee';
		foreach (\$this->list$mainTable[name] as \$i => \$onerec){
			?><tr bgcolor='#<?=\$col?>'>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
	<td>";
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			switch ($type){
				case 'on_off':
					$s.="<?php if(\$onerec['$fname']!=0){?>ON<?php }else{?>OFF<?php }?>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$onerec['$fname'], '$field[lookupfield]'));?>";
					}else{
						$s.="<?php echo(\$onerec['$fname']);?>";
					}
				break;
				case 'string':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'date':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'text':
					$s.="<?php echo(\$this->longText(\$onerec['$fname']));?>";
				break;
				case 'file':
					$s.="<?php echo(\$this->photo(\$onerec['id'], '$fname'));?>";
				break;
			}
			$s.="</td>";
		}
	}
			$s.="
	<td><a href='?view=$viewName"."Edit&id=<?=\$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=$viewName"."View&action=del$viewName"."Action&id=<?=\$onerec['id']?>'><img src='images/b_drop.png'></a></td>";
	if($childView!=''){
		$s.="
<td><a href='?view=$childView"."View&filter_check[".$crud['content']['childtable']."]=on&filter[".$crud['content']['childtable']."]=<?=\$onerec['".$crud['content']['thistable']."']?>'>Next</a></td>";
	}
	$s.="
</tr><?php
			if(\$col=='eeeeee'){\$col='dddddd';}else{\$col='eeeeee';}
		}
?>
</table>
Страница: <?php
		\$this->shkala();
	}
	function lookUp(&\$list, \$id, \$field_name){
		\$res=false;
		\$fna=explode(\":\",\$field_name);
		foreach (\$list as \$rec){
			if(\$rec['id']==\$id){
				\$res='';
				foreach (\$fna as \$ofn){
					\$res.=\$rec[\$ofn].' ';
				}
			}
		}
		return \$res;
	}
	function lookUpList(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\".\$rec['id'].\"'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.=\">\";
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function longText(\$s, \$len=50){
		if(strlen(\$s)>\$len){
			return substr(\$s,0,\$len).'...';
		}else{
			return \$s;
		}
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
	function shkala(){
		\$cnt=round(\$this->cnt / \$this->limit + 0.5);
		for(\$i=0;\$i<\$cnt;\$i++){
			if(\$i>0){
				?> | <?php
			}
			if(\$i+1==\$this->page){
				echo (\$i+1);
			}else{
				?><a href='?view=$viewName"."View&page=<?php echo(\$i);?>'><?php echo (\$i+1);?></a><?php
			}
		}
	}
}
?>";
	return $s;
}
?><?php
class CRUDpattern{
	var $dbproduct;
	var $dbcategory;
	var $listProduct;
	var $listCategory;
	var $filter;
	var $where;
	var $page;
	var $limit;
	var $order;
	var $cnt;
	
	function CRUDpattern(){
		//инициализация конфигурации
		if(!isset($_SESSION['CRUDpattern'])){
			$_SESSION['CRUDpattern']['filter']=array();
			$_SESSION['CRUDpattern']['page']=1;
			$_SESSION['CRUDpattern']['limit']=100;
			$_SESSION['CRUDpattern']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['CRUDpattern']['filter']=array();
			//перебираем поля формы фильтра
			foreach ($_REQUEST['filter'] as $fid=>$fval){
				//если чекбокс данного фильтра включён, то запоминаем его состояние
				if($_REQUEST['filter_check'][$fid]=='on'){
					$_SESSION['CRUDpattern']['filter'][mysql_escape_string($fid)] = mysql_escape_string($fval);
				}
			}
		}
		if(isset($_REQUEST['start'])){$_SESSION['CRUDpattern']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['CRUDpattern']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['CRUDpattern']['order'] = mysql_escape_string($_REQUEST['order']);
		}
		if(isset($_REQUEST['filter_id'])){
			$_SESSION['CRUDpattern']['filter']=array("id"=>$_REQUEST['filter_id']*1);
		}
		
		$this->filter=$_SESSION['CRUDpattern']['filter'];
		$this->start=$_SESSION['CRUDpattern']['page'];
		$this->limit=$_SESSION['CRUDpattern']['limit'];
		$this->order=$_SESSION['CRUDpattern']['order'];
		
		//создаём объекты доступа к таблицам
		$this->dbproduct=new dbproduct();
		$this->dbcategory=new dbcategory();
		
		//создать из $filter => $where
		$this->where='';
		$d='';
		foreach ($this->filter as $fid => $fval){
			$this->where.=$d."`$fid`='$fval'";
			$d=' AND ';
		}
		
		$this->cnt = $this->dbproduct->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listProduct=$this->dbproduct->load($this->where, $this->order, $start, $this->limit);
		
		//получаем лист для lookUp
		$this->listCategory=$this->dbcategory->load('','',0,0);
	}
	
	function Paint(){
		$this->shkala();
		?><a href='?view=CRUDpattern&action=addProduct'>Add</a>
<table border="1">
<tr>
	<td>id</td>
	<td>category</td>
	<td>name</td>
	<td>desc</td>
	<td>photo</td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<?php
		foreach ($this->listProduct as $i => $onerec){
			?><tr>
	<td><?=$onerec['id']?></td>
	<td><?php echo($this->lookUp($this->listCategory, $onerec['category'], 'category'));?></td>
	<td><?=$onerec['name']?></td>
	<td><?php echo($this->longText($onerec['desc']));?></td>
	<td><?php echo($this->photo($onerec['photo']));?></td>
	<td><a href='?view=editProduct&id=<?=$onerec['id']?>'>Edit</a></td>
	<td><a href='?view=CRUDpattern&action=delProduct&id=<?=$onerec['id']?>'>Del</a></td>
	<td><a href='?view=nextCRUDpattern&next_id=<?=$onerec['category']?>'>Next</a></td>
</tr><?php
		}
?>
</table>
		<?php
		$this->shkala();
	}
	function lookUp(&$list, $id, $field_name){
		$res=false;
		foreach ($list as $rec){
			if($rec['id']==$id){
				$res=$rec[$field_name];
			}
		}
		return $res;
	}
	function longText($s, $len){
		if(strlen($s)>$len){
			return substr($s,0,$len).'...';
		}else{
			return $s;
		}
	}
	function photo($photo){
		$path=photoPath($photo);
		if(file_exists($path)){
			return "<img src='$path'>";
		}else{
			return './photo/noimage.png';
		}
	}
	function shkala(){
		$cnt=round($this->cnt / $this->limit + 0.5);
		for($i=0;$i<$cnt;$i++){
			if($i>0){
				?> | <?php
			}
			if($i+1==$this->page){
				echo ($i+1);
			}else{
				?><a href='?view=CRUDpattern&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?><?php
function makeViewCRUDclass($project, $pid, $tables){
	$crud=$project[$pid];
	$parent=$project[$crud['parent']];
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$childView='';
	$s="<?php
class ".$viewName."ViewBO{
	var \$db$mainTable[name];
	var \$list$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="var \$filter;
	var \$filter_check;
	var \$where='';
	var \$page=1;
	var \$limit=0;
	var \$order='';
	var \$cnt;
	var \$childView='';
	
	function ".$viewName."ViewBO(){
		//инициализация конфигурации
		if(!isset(\$_SESSION['$viewName'])){
			\$_SESSION['$viewName']['filter']=array();
			\$_SESSION['$viewName']['filter_check']=array();
			\$_SESSION['$viewName']['page']=1;
			\$_SESSION['$viewName']['limit']=100;
			\$_SESSION['$viewName']['order']='';
		}
		//собираем входные данные
		if(isset(\$_REQUEST['filter']) && is_array(\$_REQUEST['filter'])){
			\$_SESSION['$viewName']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			\$datafields=array();
";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$s.="\$_SESSION['$viewName']['filter']['id'] = mysql_escape_string(\$_REQUEST['filter']['id']);//*
\$_SESSION['$viewName']['filter_check']['id'] = \$_REQUEST['filter_check']['id'] == 'on';
";
			}else{
				$type=$mainTable['fields'][$fname]['type'];
				if($type=='date'){
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_from'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_from']);
\$_SESSION['$viewName']['filter_check']['$fname"."_from'] = \$_REQUEST['filter_check']['$fname"."_from'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_from']='from';
";
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_to'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_to']);
\$_SESSION['$viewName']['filter_check']['$fname"."_to'] = \$_REQUEST['filter_check']['$fname"."_to'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_to']='to';
";
					$s.="";
				}else{
					$s.="\$_SESSION['$viewName']['datafields']['$fname']='$type';
\$_SESSION['$viewName']['filter']['$fname'] = mysql_escape_string(\$_REQUEST['filter']['$fname']);
\$_SESSION['$viewName']['filter_check']['$fname'] = \$_REQUEST['filter_check']['$fname'] == 'on';
";
				}
			}
		}
	}
			$s.="
		}
		if(isset(\$_REQUEST['start'])){\$_SESSION['$viewName']['page']=\$_REQUEST['page']*1;}
		if(isset(\$_REQUEST['limit'])){\$_SESSION['$viewName']['limit']=\$_REQUEST['limit']*1;}
		if(isset(\$_REQUEST['order'])){
			\$_SESSION['$viewName']['order'] = mysql_escape_string(\$_REQUEST['order']);
		}
//		if(isset(\$_REQUEST['filter_id'])){
//			\$_SESSION['$viewName']['filter']=array(\"id\"=>\$_REQUEST['filter_id']*1);
//		}
		
		\$this->filter=\$_SESSION['$viewName']['filter'];
		\$this->filter_check=\$_SESSION['$viewName']['filter_check'];
		\$this->start=\$_SESSION['$viewName']['page'];
		\$this->limit=\$_SESSION['$viewName']['limit'];
		\$this->order=\$_SESSION['$viewName']['order'];
		//создаём объекты доступа к таблицам
		\$this->db$mainTable[name]=new db$mainTable[name]();
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
		
		//создать из \$filter => \$where
		\$this->where='';
		\$d='';
		if(is_array(\$this->filter)){
			foreach (\$this->filter as \$fid => \$fval){
				if(\$this->filter_check[\$fid]){
					if(\$_SESSION['$viewName']['datafields'][\$fid]=='from'){
						\$p0=strpos(\$fid,'_from');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`>='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='to'){
						\$p0=strpos(\$fid,'_to');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`<='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='string'){
						\$this->where.=\$d.\"`\$fid` LIKE '\$fval'\";
					}else{
						\$this->where.=\$d.\"`\$fid`='\$fval'\";
					}
					\$d=' AND ';
				}
			}
		}
		\$this->cnt = \$this->db$mainTable[name]->count(\$this->where);
		
		//получаем основной лист
		\$start=(\$this->page - 1) * \$this->limit;
		\$this->list$mainTable[name]=\$this->db$mainTable[name]->load(\$this->where, \$this->order, \$start, \$this->limit);
		";
		//определяем наличие потомка
		if($crud['content']['thistable']!=null && $crud['content']['childtable']!=null){
			$s.="//есть потомок
";
			//ищем потомка
			foreach ($project as $lpid => $element){
				if($element['parent']==$pid){
					$childView=translit($element['name']);
					$s.="\$this->childView='".$childView."';
";
				}
			}
		}
		$s.="
	}
	
	function Paint(){
		?>
";
		//проверить, кто parent
		if($parent['type']=='CRUD' || $parent['type']=='TreeCRUD'){
			$s.="<a href='?view=".translit( $parent['name'] )."ViewBO'>&lt;&lt;&lt;&lt; Назад</br>";
		}
		$s.="
<form action='?view=$viewName"."ViewBO' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>";
		$col='eeeeee';
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			$s.="
<td valign=top bgcolor='#$col' nowrap>";
			if($col=='eeeeee'){$col='dddddd';}else{$col='eeeeee';}
			switch ($type){
				case 'on_off':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=checkbox name='filter[$fname]' value='on' <?php if(\$this->filter['$fname']!=0){?> checked<?php }?>'>";
				break;
				case 'int':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					//проверить, не является ли lookUp
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUpList(\$this->list$lookUpTable[name], \$this->filter['$fname'], '$field[lookupfield]', 'filter[$fname]'));?>";
					}else{
						$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
					}
				break;
				case 'string':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input class=filter type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'date':
					$s.="<input type='checkbox' name='filter_check[$fname"."_from]' <?php if(\$this->filter_check['$fname"."_from']){ echo(\" checked\");}?> value='on'>$fname"."_from:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_from_fd' name='filter[$fname"."_from]' value='<?php echo(\$this->filter['$fname"."_from']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_from_fd', 'datetime', 'filter_$fname"."_from_fd');\"><br>";
					$s.="<input type='checkbox' name='filter_check[$fname"."_to]' <?php if(\$this->filter_check['$fname"."_to']){ echo(\" checked\");}?> value='on'>$fname"."_to:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_to_fd' name='filter[$fname"."_to]' value='<?php echo(\$this->filter['$fname"."_to']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_to_fd', 'datetime', 'filter_$fname"."_to_fd');\">";
				break;
				case 'text':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input class=filter type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'file':
					$s.="";
				break;
			}
$s.="</td>";
		}
	}
$s.="</tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href=\"?view=$viewName"."ViewBO&action=add$viewName"."ActionBO\"'><br>
Страница: <?php \$this->shkala();?>
<table border=\"1\">
<tr bgcolor='#cccccc'>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
<td>$fname</td>";
		}
	}
	$s.="
<td></td>
<td></td>";
	if($childView!=''){
		$s.="
<td></td>";
	}
	$s.="
</tr>
<?php
		\$col='eeeeee';
		foreach (\$this->list$mainTable[name] as \$i => \$onerec){
			?><tr bgcolor='#<?=\$col?>'>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
	<td>";
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			switch ($type){
				case 'on_off':
					$s.="<?php if(\$onerec['$fname']!=0){?>ON<?php }else{?>OFF<?php }?>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$onerec['$fname'], '$field[lookupfield]'));?>";
					}else{
						$s.="<?php echo(\$onerec['$fname']);?>";
					}
				break;
				case 'string':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'date':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'text':
					$s.="<?php echo(\$this->longText(\$onerec['$fname']));?>";
				break;
				case 'file':
					$s.="<?php echo(\$this->photo(\$onerec['id'], '$fname'));?>";
				break;
			}
			$s.="</td>";
		}
	}
			$s.="
	<td><a href='?view=$viewName"."EditBO&id=<?=\$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=$viewName"."ViewBO&action=del$viewName"."ActionBO&id=<?=\$onerec['id']?>'><img src='images/b_drop.png'></a></td>";
	if($childView!=''){
		$s.="
<td><a href='?view=$childView"."ViewBO&filter_check[".$crud['content']['childtable']."]=on&filter[".$crud['content']['childtable']."]=<?=\$onerec['".$crud['content']['thistable']."']?>'>Next</a></td>";
	}
	$s.="
</tr><?php
			if(\$col=='eeeeee'){\$col='dddddd';}else{\$col='eeeeee';}
		}
?>
</table>
Страница: <?php
		\$this->shkala();
	}
	function lookUp(&\$list, \$id, \$field_name){
		\$res=false;
		\$fna=explode(\":\",\$field_name);
		foreach (\$list as \$rec){
			if(\$rec['id']==\$id){
				\$res='';
				foreach (\$fna as \$ofn){
					\$res.=\$rec[\$ofn].' ';
				}
			}
		}
		return \$res;
	}
	function lookUpList(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\".\$rec['id'].\"'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.=\">\";
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function longText(\$s, \$len=50){
		if(strlen(\$s)>\$len){
			return substr(\$s,0,\$len).'...';
		}else{
			return \$s;
		}
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
	function shkala(){
		\$cnt=round(\$this->cnt / \$this->limit + 0.5);
		for(\$i=0;\$i<\$cnt;\$i++){
			if(\$i>0){
				?> | <?php
			}
			if(\$i+1==\$this->page){
				echo (\$i+1);
			}else{
				?><a href='?view=$viewName"."ViewBO&page=<?php echo(\$i);?>'><?php echo (\$i+1);?></a><?php
			}
		}
	}
}
?>";
	return $s;
}
?><?php
function makeDBclass($table){
$s='class db'.$table['name'].'{
	function count($where=""){
		$sql="SELECT count(*) as cnt FROM `'.$table['name'].'`";
		if($where!=""){
			$sql.=" WHERE $where";
		}
		$r=mysql_query($sql);
		return mysql_result($r,0,"cnt");
	}
	function load($where="", $order="", $start=0, $limit=0){
		$sql="SELECT * FROM `'.$table['name'].'`";
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
';			
			foreach ($table['fields'] as $field_name => $field){
				$s.="\$$field_name = mysql_result(\$r,\$i,'$field_name');
";
			}
			$s.="\$list[]=array(\"id\"=>\$id";
			foreach ($table['fields'] as $field_name => $field){
				$s.=", \"$field_name\"=>\$$field_name";
			}
			$s.=');
		}
		return $list;
	}
	function get($id){
		$sql="SELECT * FROM `'.$table['name'].'` WHERE id=$id";
		$r=mysql_query($sql);
		$n=mysql_num_rows($r);
		if($n>0){
			$id=mysql_result($r,0,"id");
';
			foreach ($table['fields'] as $field_name => $field){
				$s.="\$$field_name = mysql_result(\$r,\$i,'$field_name');
";
			}
			$s.='return array("id"=>$id';
			foreach ($table['fields'] as $field_name => $field){
				$s.=", \"$field_name\"=>\$$field_name";
			}
			$s.=');
		}else{
			return false;
		}
	}
	function add(';
	$d='';
	foreach ($table['fields'] as $field_name => $field){
		$s.=$d.'$'.$field_name;
		$d=', ';
	}
	$s.='){
		$sql="INSERT INTO `'.$table['name'].'`(';
	$d='';
		foreach ($table['fields'] as $field_name => $field){
			$s.=$d.'`'.$field_name.'`';
			$d=', ';
		}
		$s.=') VALUES(';
		$d='';
		foreach ($table['fields'] as $field_name => $field){
			$s.=$d.'\'$'.$field_name.'\'';
			$d=', ';
		}
		$s.=')";
		mysql_query($sql);
		return mysql_insert_id();
	}
	function del($id){
		$sql="DELETE FROM `'.$table['name'].'` WHERE id=$id";
		mysql_query($sql);
	}
	function update($id';
	foreach ($table['fields'] as $field_name => $field){
		$s.=', $'.$field_name;
	}
	$s.='){
		$sql="UPDATE `'.$table['name'].'` SET ";
		$d=\'\';';
		foreach ($table['fields'] as $field_name => $field){
			$s.="if(\$$field_name!==null){
				\$sql.=\$d.' `$field_name`=\"'.\$$field_name.'\"';
				\$d=', ';
			}";
		}
		$s.='
		$sql.=" WHERE id=$id";
		mysql_query($sql);
	}
}';
		return $s;
}
?><?php
function makeEditCRUDclassFO($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class ".$viewName."Edit{
	var \$id;
	var \$db$mainTable[name];
	var \$$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="function ".$viewName."Edit(){
		\$this->id=\$_REQUEST['id']*1;
		\$this->db$mainTable[name] = new db$mainTable[name]();
		\$this->$mainTable[name] = \$this->db$mainTable[name]->get(\$this->id);
		
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
	}
	function Paint(){
		?>
		<a href='?view=".$viewName."View'>К списку</a>
		<table border=\"1\">
		<form method=\"POST\" enctype=\"multipart/form-data\" action=\"?view=".$viewName."Edit&action=update".$viewName."Action&id=<?=\$this->id?>\">
";
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				$s.="
			<tr><td>$fname</td><td>";
				if($fname=='ID'){
					$type='int';
					$fname='id';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				switch ($type){
					case 'on_off':
						$s.="<input type=checkbox name=\"$fname\" value='1' <?php if(\$this->$mainTable[name]"."['$fname']!=0){ ?> checked<?php } ?>>";
					break;
					case 'int':
						//проверить, не является ли lookUp
						if($field['lookup']>0){
							$lookUpTable=$tables[$field['lookup']];
							$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$this->$mainTable[name]"."['$fname'], '$field[lookupfield]', '$fname'));?>";
						}else{
							$s.="<input type=\"text\" name=\"$fname\" value=\"<?php echo(\$this->$mainTable[name]"."['$fname']);?>\">";
						}
					break;
					case 'string':
						$s.="<input type=\"text\" name=\"$fname\" value=\"<?php echo(htmlspecialchars(\$this->$mainTable[name]"."['$fname']));?>\">";
					break;
					case 'date':
						$s.="<input type=\"text\" name=\"$fname\" id=\"$fname"."_fd\" value=\"<?php echo(\$this->$mainTable[name]"."['$fname']);?>\"><img src='images/b_calendar.png' onclick=\"openCalendar('', '', '$fname"."_fd', 'datetime', '$fname"."_fd');\">";
					break;
					case 'text':
						$s.="<textarea name=\"$fname\"><?php echo(\$this->$mainTable[name]"."['$fname']);?></textarea>";
					break;
					case 'file':
						$s.="<?php echo(\$this->photo(\$this->id, '$fname'));?><br><input type=\"file\" name=\"$fname\">";
					break;
				}
				$s.="</td></tr>";
			}
		}
		$s.="
		<tr><td colspan=\"2\"><input value=\" O.K. \" type=\"submit\"></td></tr>
		</form>
		</table>
		<?php
	}
	function lookUp(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\$rec[id]'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.='>';
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
}
?>";
	return $s;
}
?><?php
class editProductViewBO{
	var $id;
	var $dbproduct;
	var $product;
	var $dbcategory;
	var $listcategory;
	function editProductViewBO(){
		$this->id=$_REQUEST['id']*1;
		$this->dbproduct = new dbproduct();
		$this->product = $this->dbproduct->get($this->id);
		$this->dbcategory = new dbcategory();
		$this->listcategory = $this->dbcategory->load('','',0,0);
	}
	function Paint(){
		?>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=editProductViewBO&id=<?=$this->id?>">
		<tr><td>id</td><td><?=$this->product['id']?></td></tr>
		<tr><td>category</td><td><?php echo($this->lookUp($this->listcategory, $this->product['category'], 'category', 'category'));?></td></tr>
		<tr><td>name</td><td><input type="text" name="name" value="<?=$this->product['name']?>"></td></tr>
		<tr><td>desc</td><td><textarea name="desc"><?=$this->product['desc']?></textarea></td></tr>
		<tr><td>photo</td><td>
			<img src="<?php echo(photoPath($this->product['photo']));?>">
			<br><input type="file" name="photo">
			</td></tr>
		<tr><td colspan="2"><input value=" O.K. " type="submit"></td></tr>
		</form>
		</table>
		<?php
	}
	function lookUp(&$list, $id, $field_name, $name){
		$s="<select name='$name'>
";
		if(is_array($list)){
			foreach ($list as $rec){
				$s.="<option value=''";
				if($rec['id']==$id){
					$s.=" select";
				}
				$s.=">$rec[$field_name]</option>
";
			}
		}
		$s.="</select>
";
		return $s;
	}
}
?><?php
function makeEditCRUDclass($crud, $tables){
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$s="<?php
class ".$viewName."EditBO{
	var \$id;
	var \$db$mainTable[name];
	var \$$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="function ".$viewName."EditBO(){
		\$this->id=\$_REQUEST['id']*1;
		\$this->db$mainTable[name] = new db$mainTable[name]();
		\$this->$mainTable[name] = \$this->db$mainTable[name]->get(\$this->id);
		
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
	}
	function Paint(){
		?>
		<a href='?view=".$viewName."ViewBO'>К списку</a>
		<table border=\"1\">
		<form method=\"POST\" enctype=\"multipart/form-data\" action=\"?view=".$viewName."EditBO&action=update".$viewName."ActionBO&id=<?=\$this->id?>\">
";
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				$s.="
			<tr><td>$fname</td><td>";
				if($fname=='ID'){
					$type='int';
					$fname='id';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				switch ($type){
					case 'on_off':
						$s.="<input type=checkbox name=\"$fname\" value='1' <?php if(\$this->$mainTable[name]"."['$fname']!=0){ ?> checked<?php } ?>>";
					break;
					case 'int':
						//проверить, не является ли lookUp
						if($field['lookup']>0){
							$lookUpTable=$tables[$field['lookup']];
							$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$this->$mainTable[name]"."['$fname'], '$field[lookupfield]', '$fname'));?>";
						}else{
							$s.="<input type=\"text\" name=\"$fname\" value=\"<?php echo(\$this->$mainTable[name]"."['$fname']);?>\">";
						}
					break;
					case 'string':
						$s.="<input type=\"text\" name=\"$fname\" value=\"<?php echo(htmlspecialchars(\$this->$mainTable[name]"."['$fname']));?>\">";
					break;
					case 'date':
						$s.="<input type=\"text\" name=\"$fname\" id=\"$fname"."_fd\" value=\"<?php echo(\$this->$mainTable[name]"."['$fname']);?>\"><img src='images/b_calendar.png' onclick=\"openCalendar('', '', '$fname"."_fd', 'datetime', '$fname"."_fd');\">";
					break;
					case 'text':
						$s.="<textarea name=\"$fname\"><?php echo(\$this->$mainTable[name]"."['$fname']);?></textarea>";
					break;
					case 'file':
						$s.="<?php echo(\$this->photo(\$this->id, '$fname'));?><br><input type=\"file\" name=\"$fname\">";
					break;
				}
				$s.="</td></tr>";
			}
		}
		$s.="
		<tr><td colspan=\"2\"><input value=\" O.K. \" type=\"submit\"></td></tr>
		</form>
		</table>
		<?php
	}
	function lookUp(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\$rec[id]'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.='>';
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
}
?>";
	return $s;
}
?><?php
session_start();
require_once('connect_db.php');
require_once('authFO.php');
require_once('lib.php');
requireDir('Models/');
requireDir('View/');
requireDir('Action/');

//проверяем попытку авторизации
if(isset($_REQUEST['login']) && isset($_REQUEST['password'])){
	loginFO($_REQUEST['login'], $_REQUEST['password']);
}

$menu = new menuFO();

if(isset($_REQUEST['action'])){
	//проверит авторизацию
	if(checkAuthFO($_SESSION['front_user_id'], $_REQUEST['action'])){
		eval("\$action=new $_REQUEST[action]();");
		$action->Go();
	}
}
if(isset($_REQUEST['view'])){
	//проверит авторизацию
	if(checkAuthFO($_SESSION['front_user_id'], $_REQUEST['view'])){
		eval("\$view=new $_REQUEST[view]();");
	}
}else{
	$view=null;
}
?>
<html>
<head>
<title>Tarion</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="tbl_change.js"></script>
<?php $menu->Paint();?>
<td align="right">
<input type="button" onclick="document.getElementById('authTable').style.display='block';" value="Авторизация">
</td>
</tr>
</table>
<table id='authTable' style="position:absolute;top:300px;left:300px;width:150px;background-color:Aqua;display:none;">
<form method="POST" action="">
<tr><td>login:</td><td><input type="text" name="login" style="width:80px;height:18px;"></td></tr>
<tr><td>password:</td><td><input type="password" name="password" style="width:80px;height:18px;"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Вход" style="height:18px;"></td></tr>
<tr><td colspan="2" align="center"><a href="?view=registrFormView">Регистрация</a></td></tr>
</form>
</table>
<script>
document.getElementById('authTable').style.left=Math.round(document.body.clientWidth/2 - 150/2);
</script>

<br>
<table width="100%" border="1">
<tr></tr>
	<td valign="top"><?php if($view!=null){$view->Paint();}?></td>
</tr>
</table>
</body>
</html><?php
/**
* transliterate text
*
* @param string $text
* @return string
*/
function translit($text) {
	$lat='QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890_';
	$trans = array(
"а" => "a",
"б" => "b",
"в" => "v",
"г" => "g",
"д" => "d",
"е" => "e",
"ё" => "e",
"ж" => "zh",
"з" => "z",
"и" => "i",
"й" => "y",
"к" => "k",
"л" => "l",
"м" => "m",
"н" => "n",
"о" => "o",
"п" => "p",
"р" => "r",
"с" => "s",
"т" => "t",
"у" => "u",
"ф" => "f",
"х" => "kh",
"ц" => "ts",
"ч" => "ch",
"ш" => "sh",
"щ" => "shch",
"ы" => "y",
"э" => "e",
"ю" => "yu",
"я" => "ya",
"А" => "A",
"Б" => "B",
"В" => "V",
"Г" => "G",
"Д" => "D",
"Е" => "E",
"Ё" => "E",
"Ж" => "Zh",
"З" => "Z",
"И" => "I",
"Й" => "Y",
"К" => "K",
"Л" => "L",
"М" => "M",
"Н" => "N",
"О" => "O",
"П" => "P",
"Р" => "R",
"С" => "S",
"Т" => "T",
"У" => "U",
"Ф" => "F",
"Х" => "Kh",
"Ц" => "Ts",
"Ч" => "Ch",
"Ш" => "Sh",
"Щ" => "Shch",
"Ы" => "Y",
"Э" => "E",
"Ю" => "Yu",
"Я" => "Ya",
"ь" => "",
"Ь" => "",
"ъ" => "",
"Ъ" => ""
 );
	if(preg_match("/[а-яА-Я]/", $text)){
		$s=strtr($text, $trans);
	}else{
		$s=$text;
	}
	for ($i=0;$i<strlen($s);$i++){
		if(strpos($lat,$s[$i])===false){$s[$i]='_';}
	}
	return $s;
}

function photoPath($photo){
	$path='./photo/'.round($photo/1000);
	if(!file_exists($path)){
		mkdir($path);
		chmod($path, 0777);
	}
	$path.='/'.$photo;
	if(!file_exists($path)){
		mkdir($path);
		chmod($path, 0777);
	}
	return $path;
}

function requireDir($path){
	$d=dir($path);
	while (false !== ($entry = $d->read())) {
		if($entry!='.' && $entry!='..'){
			require_once($path.$entry);
		}
	}
	$d->close();
}
?><?php
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
?><?php
function makeRegistredFormBO($tables){
	$s="<?php
class registredFormViewBO{
	function registredFormViewBO(){}
	function Paint(){
?>
Вы зарегистрированы с минимальными правами. Обратитесь к администратору.
<table border=\"1\">
<tr>
	<td>login</td>
	<td><?php echo \$_SESSION['registr']['login'];?></td>
</tr>
";
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){
		$s.="<tr>
	<td>$fname</td>
	<td><?php echo \$_SESSION['registr']['$fname'];?></td>
</tr>
";
		}
	}
$s.="
</table>
<?php
	}
}
?>";
	return $s;
}
?><?php
function makeRegistredFormFO($tables){
	$s="<?php
class registredFormView{
	function registredFormView(){}
	function Paint(){
?>
Вы зарегистрированы с минимальными правами. Обратитесь к администратору.
<table border=\"1\">
<tr>
	<td>login</td>
	<td><?php echo \$_SESSION['registr']['login'];?></td>
</tr>
";
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){
		$s.="<tr>
	<td>$fname</td>
	<td><?php echo \$_SESSION['registr']['$fname'];?></td>
</tr>
";
		}
	}
$s.="
</table>
<?php
	}
}
?>";
	return $s;
}
?><?php
function makeRegistrFormBO($tables){
	$s="<?php
class registrFormViewBO{
	function registrFormViewBO(){}
	function Paint(){
?>
<form method=\"POST\" action=\"?view=registredFormViewBO&action=registrFormActionBO\">
<table border=\"1\">
<tr>
	<td>login</td>
	<td><input type=\"text\" name=\"login\" value=\"<?php echo \$_SESSION['registr']['login'];?>\"></td>
</tr>
<tr>
	<td>password</td>
	<td><input type=\"password\" name=\"password\"></td>
</tr>
<tr>
	<td>Подтвердите пароль</td>
	<td><input type=\"password\" name=\"password2\"><?php
	if(\$_SESSION['registr']['error']=='password error'){?><br>
Вы ввели разные пароли.
	<?php
	}
	?></td>
</tr>";
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){
		$s.="<tr>
	<td>$fname</td>
	<td><input type='text' name='$fname' value='<?php echo \$_SESSION['registr']['$fname'];?>'></td>
</tr>
";
		}
	}
$s.="<tr>
	<td><img src='capche.php?dt=<?php echo date('H:i:s');?>'></td>
	<td><input type=\"text\" name=\"capche\"><?php if(\$_SESSION['registr']['error']=='capche error'){?>Вы неверно ввели контрольный код.<?php
	}?></td>
</tr>
<tr>
	<td colspan=2><input type=\"submit\" value=\"Зарегистрироваться\"></td>
</tr></table>
</form>
<?php
	}
}
?>";
	return $s;
}
?><?php
function makeRegistrFormFO($tables){
	$s="<?php
class registrFormView{
	function registrFormView(){}
	function Paint(){
?>
<form method=\"POST\" action=\"?view=registredFormView&action=registrFormAction\">
<table border=\"1\">
<tr>
	<td>login</td>
	<td><input type=\"text\" name=\"login\" value=\"<?php echo \$_SESSION['registr']['login'];?>\"></td>
</tr>
<tr>
	<td>password</td>
	<td><input type=\"password\" name=\"password\"></td>
</tr>
<tr>
	<td>Подтвердите пароль</td>
	<td><input type=\"password\" name=\"password2\"><?php
	if(\$_SESSION['registr']['error']=='password error'){?><br>
Вы ввели разные пароли.
	<?php
	}
	?></td>
</tr>";
	foreach ($tables as $i => $table){
		if($table['name']=='user'){break;}
	}
	foreach ($table['fields'] as $fname => $field){
		if($fname!='login' &&
		$fname!='password' &&
		$fname!='right'){
		$s.="<tr>
	<td>$fname</td>
	<td><input type='text' name='$fname' value='<?php echo \$_SESSION['registr']['$fname'];?>'></td>
</tr>
";
		}
	}
$s.="<tr>
	<td><img src='capche.php?dt=<?php echo date('H:i:s');?>'></td>
	<td><input type=\"text\" name=\"capche\"><?php if(\$_SESSION['registr']['error']=='capche error'){?>Вы неверно ввели контрольный код.<?php
	}?></td>
</tr>
<tr>
	<td colspan=2><input type=\"submit\" value=\"Зарегистрироваться\"></td>
</tr></table>
</form>
<?php
	}
}
?>";
	return $s;
}
?><?php
function makeViewTreeCRUDclassFO($project, $pid, $tables){
	$crud=$project[$pid];
	$parent=$project[$crud['parent']];
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$childView='';
	$s="<?php
class ".$viewName."View{
	var \$db$mainTable[name];
	var \$list$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="var \$filter;
	var \$filter_check;
	var \$parent;
	var \$where='';
	var \$page=1;
	var \$limit=0;
	var \$order='';
	var \$cnt;
	var \$childView='';
	
	function ".$viewName."View(){
		//инициализация конфигурации
		if(!isset(\$_SESSION['$viewName'])){
			\$_SESSION['$viewName']['filter']=array();
			\$_SESSION['$viewName']['filter_check']=array();
			\$_SESSION['$viewName']['page']=1;
			\$_SESSION['$viewName']['limit']=100;
			\$_SESSION['$viewName']['order']='';
		}
		//собираем входные данные
		if(isset(\$_REQUEST['filter']) && is_array(\$_REQUEST['filter'])){
			\$_SESSION['$viewName']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			\$_SESSION['$viewName']['datafields']=array();
";
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$s.="\$_SESSION['$viewName']['filter']['id'] = mysql_escape_string(\$_REQUEST['filter']['id']);//*
\$_SESSION['$viewName']['filter_check']['id'] = \$_REQUEST['filter_check']['id'] == 'on';
";
			}else{
				$type=$mainTable['fields'][$fname]['type'];
				if($type=='date'){
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_from'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_from']);
\$_SESSION['$viewName']['filter_check']['$fname"."_from'] = \$_REQUEST['filter_check']['$fname"."_from'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_from']='from';
";
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_to'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_to']);
\$_SESSION['$viewName']['filter_check']['$fname"."_to'] = \$_REQUEST['filter_check']['$fname"."_to'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_to']='to';
";
					$s.="";
				}else{
					$s.="\$_SESSION['$viewName']['datafields']['$fname']='$type';
\$_SESSION['$viewName']['filter']['$fname'] = mysql_escape_string(\$_REQUEST['filter']['$fname']);
\$_SESSION['$viewName']['filter_check']['$fname'] = \$_REQUEST['filter_check']['$fname'] == 'on';
";
				}
			}
		}
	}
			$s.="
		}
		if(isset(\$_REQUEST['start'])){\$_SESSION['$viewName']['page']=\$_REQUEST['page']*1;}
		if(isset(\$_REQUEST['limit'])){\$_SESSION['$viewName']['limit']=\$_REQUEST['limit']*1;}
		if(isset(\$_REQUEST['order'])){
			\$_SESSION['$viewName']['order'] = mysql_escape_string(\$_REQUEST['order']);
		}
		if(isset(\$_REQUEST['filter_id'])){
			\$_SESSION['$viewName']['filter']=array(\"id\"=>\$_REQUEST['filter_id']*1);
		}
		
		\$this->filter=\$_SESSION['$viewName']['filter'];
		\$this->filter_check=\$_SESSION['$viewName']['filter_check'];
		\$this->start=\$_SESSION['$viewName']['page'];
		\$this->limit=\$_SESSION['$viewName']['limit'];
		\$this->order=\$_SESSION['$viewName']['order'];
		//создаём объекты доступа к таблицам
		\$this->db$mainTable[name]=new db$mainTable[name]();
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
		if(isset(\$_REQUEST['parent'])){
			\$this->parent=\$_REQUEST['parent']*1;
			\$_SESSION['$viewName']['parent']=\$this->parent;
		}else{
			if(isset(\$_SESSION['$viewName']['parent'])){
				\$this->parent=\$_SESSION['$viewName']['parent'];
			}else{
				\$this->parent=0;
			}
		}
		//создать из \$filter => \$where
		\$this->where=\" `".$crud['content']['parent_key']."`='\$this->parent'\";
		\$d=' AND';
		if(is_array(\$this->filter)){
			foreach (\$this->filter as \$fid => \$fval){
				if(\$this->filter_check[\$fid]){
					if(\$_SESSION['$viewName']['datafields'][\$fid]=='from'){
						\$p0=strpos(\$fid,'_from');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`>='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='to'){
						\$p0=strpos(\$fid,'_to');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`<='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='string'){
						\$this->where.=\$d.\"`\$fid` LIKE '\$fval'\";
					}else{
						\$this->where.=\$d.\"`\$fid`='\$fval'\";
					}
					\$d=' AND ';
				}
			}
		}
		\$this->cnt = \$this->db$mainTable[name]->count(\$this->where);
		
		//получаем основной лист
		\$start=(\$this->page - 1) * \$this->limit;
		\$this->list$mainTable[name]=\$this->db$mainTable[name]->load(\$this->where, \$this->order, \$start, \$this->limit);
		";
		//определяем наличие потомка
		if($crud['content']['thistable']!=null && $crud['content']['childtable']!=null){
			$s.="//есть потомок
";
			//ищем потомка
			foreach ($project as $lpid => $element){
				if($element['parent']==$pid){
					$childView=translit($element['name']);
					$s.="\$this->childView='".$childView."';
";
				}
			}
		}
		$s.="
	}
	
	function Paint(){
		echo(\$this->parentLine().'<br>');
		?>
";
		//проверить, кто parent
		if($parent['type']=='CRUD' || $parent['type']=='TreeCRUD'){
			$s.="<a href='?view=".translit( $parent['name'] )."View'>&lt;&lt;&lt;&lt; Назад</br>";
		}
		$s.="
<form action='?view=$viewName"."View' method=post>
<table border=1><tr>";
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			$s.="
<td>";
			switch ($type){
				case 'on_off':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=checkbox name='filter[$fname]' value='on' <?php if(\$this->filter['$fname']!=0){?> checked<?php }?>'>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUpList(\$this->list$lookUpTable[name], \$this->filter['$fname'], '$field[lookupfield]', 'filter[$fname]'));?>";
					}else{
						$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
					}
				break;
				case 'string':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'date':
					$s.="<input type='checkbox' name='filter_check[$fname"."_from]' <?php if(\$this->filter_check['$fname"."_from']){ echo(\" checked\");}?> value='on'>$fname"."_from:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_from_fd' name='filter[$fname"."_from]' value='<?php echo(\$this->filter['$fname"."_from']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_from_fd', 'datetime', 'filter_$fname"."_from_fd');\"><br>";
					$s.="<input type='checkbox' name='filter_check[$fname"."_to]' <?php if(\$this->filter_check['$fname"."_to']){ echo(\" checked\");}?> value='on'>$fname"."_to:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_to_fd' name='filter[$fname"."_to]' value='<?php echo(\$this->filter['$fname"."_to']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_to_fd', 'datetime', 'filter_$fname"."_to_fd');\">";
				break;
				case 'text':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'file':
					$s.="";
				break;
			}
$s.="</td>";
		}
	}
$s.="</tr></table>
<input type='submit' value='Фильтр'>
</form>
<br>
<a href='?view=$viewName"."View&action=add$viewName"."Action";
		$s.="<?php if(\$this->parent!=0){
		echo \"&".$crud['content']['parent_key']."=\$this->parent\"; } ?>";
		$s.="'>Add</a><br>
Страница:  <?php \$this->shkala(); ?>
<table border=\"1\">
<tr>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
<td>$fname</td>";
		}
	}
	$s.="
<td></td>
<td></td>
<td></td>";
	if($childView!=''){
		$s.="
<td></td>";
	}
	$s.="
</tr>
<?php
		foreach (\$this->list$mainTable[name] as \$i => \$onerec){
			?><tr>";
	//foreach ($mainTable['fields'] as $fname => $field){
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
	<td>";
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			switch ($type){
				case 'on_off':
					$s.="<?php if(\$onerec['$fname']!=0){?>ON<?php }else{?>OFF<?php }?>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$onerec['$fname'], '$field[lookupfield]'));?>";
					}else{
						$s.="<?php echo(\$onerec['$fname']);?>";
					}
				break;
				case 'string':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'date':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'text':
					$s.="<?php echo(\$this->longText(\$onerec['$fname']));?>";
				break;
				case 'file':
					$s.="<?php echo(\$this->photo(\$onerec['id'], '$fname'));?>";
				break;
			}
			$s.="</td>";
		}
	}
			$s.="
	<td><a href='?view=$viewName"."View&parent=<?=\$onerec['id']?>'>Node</a></td>
	<td><a href='?view=$viewName"."Edit&id=<?=\$onerec['id']?>'>Edit</a></td>
	<td><a href='?view=$viewName"."View&action=del$viewName"."Action&id=<?=\$onerec['id']?>'>Del</a></td>
	";
	if($childView!=''){
		$s.="
<td><a href='?view=$childView"."View&filter_check[".$crud['content']['childtable']."]=on&filter[".$crud['content']['childtable']."]=<?=\$onerec['".$crud['content']['thistable']."']?>'>Next</a></td>";
	}
	$s.="
</tr><?php
		}
?>
</table>
		<?php
		\$this->shkala();
	}
	function parentLine(){
		\$s='';
		\$parent=\$this->parent;
		\$d='';
		while(\$parent!=0){
			\$rec=\$this->db$mainTable[name]->get(\$parent);
			\$parent=\$rec['".$crud['content']['parent_key']."'];
			\$s='<a href=\"?view=$viewName"."View&parent='.\$rec['id'].'\">'.\$rec['".$crud['content']['indicator_key']."'].'</a>'.\$d.\$s;
			\$d=' / ';
		}
		\$s='<a href=\"?view=$viewName"."View&parent=0\">All</a>'.\$d.\$s;
		return \$s;
	}
	function lookUp(&\$list, \$id, \$field_name){
		\$res=false;
		\$fna=explode(\":\",\$field_name);
		foreach (\$list as \$rec){
			if(\$rec['id']==\$id){
				\$res='';
				foreach (\$fna as \$ofn){
					\$res.=\$rec[\$ofn].' ';
				}
			}
		}
		return \$res;
	}
	function lookUpList(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\".\$rec['id'].\"'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.=\">\";
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function longText(\$s, \$len=50){
		if(strlen(\$s)>\$len){
			return substr(\$s,0,\$len).'...';
		}else{
			return \$s;
		}
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
	function shkala(){
		\$cnt=round(\$this->cnt / \$this->limit + 0.5);
		for(\$i=0;\$i<\$cnt;\$i++){
			if(\$i>0){
				?> | <?php
			}
			if(\$i+1==\$this->page){
				echo (\$i+1);
			}else{
				?><a href='?view=$viewName"."View&page=<?php echo(\$i);?>'><?php echo (\$i+1);?></a><?php
			}
		}
	}
}
?>";
	return $s;
}
?><?php
function makeViewTreeCRUDclass($project, $pid, $tables){
	$crud=$project[$pid];
	$parent=$project[$crud['parent']];
	$viewName=translit($crud['name']);
	$mainTable=$tables[$crud['content']['mainTable']];
	$childView='';
	$s="<?php
class ".$viewName."ViewBO{
	var \$db$mainTable[name];
	var \$list$mainTable[name];
";
	//соберём lookUp таблицы
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			if($fname=='ID'){
				$type='int';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			if($type=='int' && $field['lookup']>0){
				$lookUpTable=$tables[$field['lookup']];
				$s.="var \$db$lookUpTable[name];
var \$list$lookUpTable[name];
";
			}
		}
	}
	$s.="var \$filter;
	var \$filter_check;
	var \$parent;
	var \$where='';
	var \$page=1;
	var \$limit=0;
	var \$order='';
	var \$cnt;
	var \$childView='';
	
	function ".$viewName."ViewBO(){
		//инициализация конфигурации
		if(!isset(\$_SESSION['$viewName'])){
			\$_SESSION['$viewName']['filter']=array();
			\$_SESSION['$viewName']['filter_check']=array();
			\$_SESSION['$viewName']['page']=1;
			\$_SESSION['$viewName']['limit']=100;
			\$_SESSION['$viewName']['order']='';
		}
		//собираем входные данные
		if(isset(\$_REQUEST['filter']) && is_array(\$_REQUEST['filter'])){
			\$_SESSION['$viewName']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			\$_SESSION['$viewName']['datafields']=array();
";
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$s.="\$_SESSION['$viewName']['filter']['id'] = mysql_escape_string(\$_REQUEST['filter']['id']);//*
\$_SESSION['$viewName']['filter_check']['id'] = \$_REQUEST['filter_check']['id'] == 'on';
";
			}else{
				$type=$mainTable['fields'][$fname]['type'];
				if($type=='date'){
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_from'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_from']);
\$_SESSION['$viewName']['filter_check']['$fname"."_from'] = \$_REQUEST['filter_check']['$fname"."_from'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_from']='from';
";
					$s.="\$_SESSION['$viewName']['filter']['$fname"."_to'] = mysql_escape_string(\$_REQUEST['filter']['$fname"."_to']);
\$_SESSION['$viewName']['filter_check']['$fname"."_to'] = \$_REQUEST['filter_check']['$fname"."_to'] == 'on';
\$_SESSION['$viewName']['datafields']['$fname"."_to']='to';
";
					$s.="";
				}else{
					$s.="\$_SESSION['$viewName']['datafields']['$fname']='$type';
\$_SESSION['$viewName']['filter']['$fname'] = mysql_escape_string(\$_REQUEST['filter']['$fname']);
\$_SESSION['$viewName']['filter_check']['$fname'] = \$_REQUEST['filter_check']['$fname'] == 'on';
";
				}
			}
		}
	}
			$s.="
		}
		if(isset(\$_REQUEST['start'])){\$_SESSION['$viewName']['page']=\$_REQUEST['page']*1;}
		if(isset(\$_REQUEST['limit'])){\$_SESSION['$viewName']['limit']=\$_REQUEST['limit']*1;}
		if(isset(\$_REQUEST['order'])){
			\$_SESSION['$viewName']['order'] = mysql_escape_string(\$_REQUEST['order']);
		}
		if(isset(\$_REQUEST['filter_id'])){
			\$_SESSION['$viewName']['filter']=array(\"id\"=>\$_REQUEST['filter_id']*1);
		}
		
		\$this->filter=\$_SESSION['$viewName']['filter'];
		\$this->filter_check=\$_SESSION['$viewName']['filter_check'];
		\$this->start=\$_SESSION['$viewName']['page'];
		\$this->limit=\$_SESSION['$viewName']['limit'];
		\$this->order=\$_SESSION['$viewName']['order'];
		//создаём объекты доступа к таблицам
		\$this->db$mainTable[name]=new db$mainTable[name]();
";
		//соберём lookUp таблицы
		foreach ($crud['content']['view'] as $fname => $field) {
			if($field['show']){
				if($fname=='ID'){
					$type='int';
				}else{
					$type=$mainTable['fields'][$fname]['type'];
				}
				if($type=='int' && $field['lookup']>0){
					$lookUpTable=$tables[$field['lookup']];
					$s.="\$this->db$lookUpTable[name] = new db$lookUpTable[name]();
//получаем лист для lookUp
		\$this->list$lookUpTable[name]=\$this->db$lookUpTable[name]->load('','',0,0);";
				}
			}
		}
		$s.="
		if(isset(\$_REQUEST['parent'])){
			\$this->parent=\$_REQUEST['parent']*1;
			\$_SESSION['$viewName']['parent']=\$this->parent;
		}else{
			if(isset(\$_SESSION['$viewName']['parent'])){
				\$this->parent=\$_SESSION['$viewName']['parent'];
			}else{
				\$this->parent=0;
			}
		}
		//создать из \$filter => \$where
		\$this->where=\" `".$crud['content']['parent_key']."`='\$this->parent'\";
		\$d=' AND';
		if(is_array(\$this->filter)){
			foreach (\$this->filter as \$fid => \$fval){
				if(\$this->filter_check[\$fid]){
					if(\$_SESSION['$viewName']['datafields'][\$fid]=='from'){
						\$p0=strpos(\$fid,'_from');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`>='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='to'){
						\$p0=strpos(\$fid,'_to');
						\$fid=substr(\$fid,0,\$p0);
						\$this->where.=\$d.\"`\$fid`<='\$fval'\";
					}else if(\$_SESSION['$viewName']['datafields'][\$fid]=='string'){
						\$this->where.=\$d.\"`\$fid` LIKE '\$fval'\";
					}else{
						\$this->where.=\$d.\"`\$fid`='\$fval'\";
					}
					\$d=' AND ';
				}
			}
		}
		\$this->cnt = \$this->db$mainTable[name]->count(\$this->where);
		
		//получаем основной лист
		\$start=(\$this->page - 1) * \$this->limit;
		\$this->list$mainTable[name]=\$this->db$mainTable[name]->load(\$this->where, \$this->order, \$start, \$this->limit);
		";
		//определяем наличие потомка
		if($crud['content']['thistable']!=null && $crud['content']['childtable']!=null){
			$s.="//есть потомок
";
			//ищем потомка
			foreach ($project as $lpid => $element){
				if($element['parent']==$pid){
					$childView=translit($element['name']);
					$s.="\$this->childView='".$childView."';
";
				}
			}
		}
		$s.="
	}
	
	function Paint(){
		echo(\$this->parentLine().'<br>');
		?>
";
		//проверить, кто parent
		if($parent['type']=='CRUD' || $parent['type']=='TreeCRUD'){
			$s.="<a href='?view=".translit( $parent['name'] )."ViewBO'>&lt;&lt;&lt;&lt; Назад</br>";
		}
		$s.="
<form action='?view=$viewName"."ViewBO' method=post>
<input type='submit' value='Фильтр'>
<table border=1><tr>";
		foreach ($crud['content']['view'] as $fname => $field) {
		if($field['filter']){
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			$s.="
<td>";
			switch ($type){
				case 'on_off':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=checkbox name='filter[$fname]' value='on' <?php if(\$this->filter['$fname']!=0){?> checked<?php }?>'>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUpList(\$this->list$lookUpTable[name], \$this->filter['$fname'], '$field[lookupfield]', 'filter[$fname]'));?>";
					}else{
						$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
					}
				break;
				case 'string':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'date':
					$s.="<input type='checkbox' name='filter_check[$fname"."_from]' <?php if(\$this->filter_check['$fname"."_from']){ echo(\" checked\");}?> value='on'>$fname"."_from:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_from_fd' name='filter[$fname"."_from]' value='<?php echo(\$this->filter['$fname"."_from']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_from_fd', 'datetime', 'filter_$fname"."_from_fd');\"><br>";
					$s.="<input type='checkbox' name='filter_check[$fname"."_to]' <?php if(\$this->filter_check['$fname"."_to']){ echo(\" checked\");}?> value='on'>$fname"."_to:<br>";
					$s.="<input class=filter type=text id='filter_$fname"."_to_fd' name='filter[$fname"."_to]' value='<?php echo(\$this->filter['$fname"."_to']);?>'><img src='images/b_calendar.png' onclick=\"openCalendar('', '', 'filter_$fname"."_to_fd', 'datetime', 'filter_$fname"."_to_fd');\">";
				break;
				case 'text':
					$s.="<input type='checkbox' name='filter_check[$fname]' <?php if(\$this->filter_check['$fname']){ echo(\" checked\");}?> value='on'>$fname:<br>";
					$s.="<input type=text name='filter[$fname]' value='<?php echo(\$this->filter['$fname']);?>'>";
				break;
				case 'file':
					$s.="";
				break;
			}
$s.="</td>";
		}
	}
$s.="</tr></table>
</form>
<br>
<a href='?view=$viewName"."ViewBO&action=add$viewName"."ActionBO";
		$s.="<?php if(\$this->parent!=0){
		echo \"&".$crud['content']['parent_key']."=\$this->parent\"; } ?>";
		$s.="'>Add</a><br>
Страница:  <?php \$this->shkala(); ?>
<table border=\"1\">
<tr>";
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
<td>$fname</td>";
		}
	}
	$s.="
<td></td>
<td></td>
<td></td>";
	if($childView!=''){
		$s.="
<td></td>";
	}
	$s.="
</tr>
<?php
		foreach (\$this->list$mainTable[name] as \$i => \$onerec){
			?><tr>";
	//foreach ($mainTable['fields'] as $fname => $field){
	foreach ($crud['content']['view'] as $fname => $field) {
		if($field['show']){
			$s.="
	<td>";
			if($fname=='ID'){
				$type='int';
				$fname='id';
			}else{
				$type=$mainTable['fields'][$fname]['type'];
			}
			switch ($type){
				case 'on_off':
					$s.="<?php if(\$onerec['$fname']!=0){?>ON<?php }else{?>OFF<?php }?>";
				break;
				case 'int':
					//проверить, не является ли lookUp
					if($field['lookup']>0){
						$lookUpTable=$tables[$field['lookup']];
						$s.="<?php echo(\$this->lookUp(\$this->list$lookUpTable[name], \$onerec['$fname'], '$field[lookupfield]'));?>";
					}else{
						$s.="<?php echo(\$onerec['$fname']);?>";
					}
				break;
				case 'string':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'date':
					$s.="<?php echo(\$onerec['$fname']);?>";
				break;
				case 'text':
					$s.="<?php echo(\$this->longText(\$onerec['$fname']));?>";
				break;
				case 'file':
					$s.="<?php echo(\$this->photo(\$onerec['id'], '$fname'));?>";
				break;
			}
			$s.="</td>";
		}
	}
			$s.="
	<td><a href='?view=$viewName"."ViewBO&parent=<?=\$onerec['id']?>'>Node</a></td>
	<td><a href='?view=$viewName"."EditBO&id=<?=\$onerec['id']?>'>Edit</a></td>
	<td><a href='?view=$viewName"."ViewBO&action=del$viewName"."ActionBO&id=<?=\$onerec['id']?>'>Del</a></td>
	";
	if($childView!=''){
		$s.="
<td><a href='?view=$childView"."ViewBO&filter_check[".$crud['content']['childtable']."]=on&filter[".$crud['content']['childtable']."]=<?=\$onerec['".$crud['content']['thistable']."']?>'>Next</a></td>";
	}
	$s.="
</tr><?php
		}
?>
</table>
		<?php
		\$this->shkala();
	}
	function parentLine(){
		\$s='';
		\$parent=\$this->parent;
		\$d='';
		while(\$parent!=0){
			\$rec=\$this->db$mainTable[name]->get(\$parent);
			\$parent=\$rec['".$crud['content']['parent_key']."'];
			\$s='<a href=\"?view=$viewName"."ViewBO&parent='.\$rec['id'].'\">'.\$rec['".$crud['content']['indicator_key']."'].'</a>'.\$d.\$s;
			\$d=' / ';
		}
		\$s='<a href=\"?view=$viewName"."ViewBO&parent=0\">All</a>'.\$d.\$s;
		return \$s;
	}
	function lookUp(&\$list, \$id, \$field_name){
		\$res=false;
		\$fna=explode(\":\",\$field_name);
		foreach (\$list as \$rec){
			if(\$rec['id']==\$id){
				\$res='';
				foreach (\$fna as \$ofn){
					\$res.=\$rec[\$ofn].' ';
				}
			}
		}
		return \$res;
	}
	function lookUpList(&\$list, \$id, \$field_name, \$name){
		\$s=\"<select name='\$name'>
		<option value=0> --- </option>
\";
		\$fna=explode(':',\$field_name);
		if(is_array(\$list)){
			foreach (\$list as \$rec){
				\$s.=\"<option value='\".\$rec['id'].\"'\";
				if(\$rec['id']==\$id){
					\$s.=\" selected\";
				}
				\$s.=\">\";
				foreach (\$fna as \$ofn){
					\$s.=\$rec[\$ofn].' ';
				}
				\$s.=\"</option>
\";
			}
		}
		\$s.=\"</select>
\";
		return \$s;
	}
	function longText(\$s, \$len=50){
		if(strlen(\$s)>\$len){
			return substr(\$s,0,\$len).'...';
		}else{
			return \$s;
		}
	}
	function photo(\$photo, \$name){
		\$path=photoPath(\$photo).'/'.\$name;
		if(file_exists(\$path)){
			return \"<img src='\$path'>\";
		}else{
			return \"<img src='./photo/noimage.png'>\";
		}
	}
	function shkala(){
		\$cnt=round(\$this->cnt / \$this->limit + 0.5);
		for(\$i=0;\$i<\$cnt;\$i++){
			if(\$i>0){
				?> | <?php
			}
			if(\$i+1==\$this->page){
				echo (\$i+1);
			}else{
				?><a href='?view=$viewName"."ViewBO&page=<?php echo(\$i);?>'><?php echo (\$i+1);?></a><?php
			}
		}
	}
}
?>";
	return $s;
}
?><?php
class CRUD{
	var $filter;
	var $page;
	var $limit;
	
	function CRUD(){
		
	}
	function Paint(){}
}
?><?php
require_once('Models//*table*/.class.php');
class /*table*/View{
	var $page=0;
	var $limit=10;
	//fields
	function /*table*/View(){
		//fields verify
		if(isset($_REQUEST['page'])){
			$this->page=$_REQUEST['page']*1;$_SESSION['/*table*/ViewPage']=$this->page;
		}else{
			if(isset($_SESSION['/*table*/ViewPage'])){$this->page=$_SESSION['/*table*/ViewPage'];}
		}
		if(isset($_REQUEST['limit'])){
			$this->limit=$_REQUEST['limit']*1;$_SESSION['/*table*/ViewLimit']=$this->limit;
		}else{
			if(isset($_SESSION['/*table*/ViewLimit'])){$this->limit=$_SESSION['/*table*/ViewLimit'];}
		}
	}
	function Paint(){
		$db=new /*table*/Model;
		//линейку страниц
		$cnt=$db->count();
		$pages=round($cnt/$this->limit + 0.5);
		?>Страница: <?php
		for($i=1;$i<=$pages;$i++){
			?><a href='?view=/*table*/View&page=<?=$i?>'></a><?php
		}
		?><br><?php
		//страницу
		$list=array();
		$db->load($list,'','',($this->page - 1)*$this->limit, $this->limit);
		?>
		<table border="1">
		<tr>
			//fields title
		</tr>
		<?php
		foreach ($list as $i => $record){
			foreach ($record as $field => $value){
				?><td><?=$value?></td><?php
			}
		}
		?>
		</table>
		<?php
	}
}
?>