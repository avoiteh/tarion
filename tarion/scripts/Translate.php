<?php
require_once('project_init.php');
require_once('makeAuthBlocks.php');
require_once('makeTableBlock.php');
require_once('Prototype/lib.php');
require_once('Prototype/dbPattern.php');
require_once('Prototype/CRUDpattern.view.php');
require_once('Prototype/TreeCRUDpattern.view.php');
require_once('Prototype/editCRUDpattern.view.php');
require_once('Prototype/action.addCRUD.php');
require_once('Prototype/action.delCRUD.php');
require_once('Prototype/action.updateCRUD.php');

require_once('Prototype/CRUDpatternFO.view.php');
require_once('Prototype/TreeCRUDpatternFO.view.php');
require_once('Prototype/editCRUDpatternFO.view.php');
require_once('Prototype/action.addCRUDFO.php');
require_once('Prototype/action.delCRUDFO.php');
require_once('Prototype/action.updateCRUDFO.php');

require_once('Prototype/registrFormBO.view.php');
require_once('Prototype/registredFormBO.view.php');
require_once('Prototype/action.registrBO.php');
require_once('Prototype/registrFormFO.view.php');
require_once('Prototype/registredFormFO.view.php');
require_once('Prototype/action.registrFO.php');

$CFG=unserialize(file_get_contents('tarion.cfg'));
$json_answer['id']='Translate';
$json_answer['Translate']=array();
switch($json_query->mode){
	case "checkDB":
		//проверить соединение с базой
		$db=@mysql_connect ($CFG["dbhost"], $CFG["dblogin"], $CFG["dbpassword"]);
		$sdb=@mysql_select_db ($CFG["database"]);
		//создать connect_db.php
		$s="<?php
mysql_connect ('".$CFG["dbhost"]."', '".$CFG["dblogin"]."', '".$CFG["dbpassword"]."');
mysql_select_db ('".$CFG["database"]."');
?>";
		file_put_contents('../connect_db.php', $s);
		
		$json_answer['Translate']['Flag']='OK';
		$json_answer['Translate']['Mess']="Подключение к базе данных успешно.<br>host: $CFG[dbhost]<br>login: $CFG[dblogin]<br>password: $CFG[dbpassword]<br>database: $CFG[database]";
		//однако если ошибка!
		if(!$db){
			$json_answer['Translate']['Flag']='Error';
			$json_answer['Translate']['Mess']="Ошибка подключения к mysql.<br>
host: $CFG[dbhost]<br>
login: $CFG[dblogin]<br>
password: $CFG[dbpassword]";
		}else{
			if(!$sdb){
				$json_answer['Translate']['Flag']='Error';
				$json_answer['Translate']['Mess']="Ошибка подключения к базе данных.<br>
host: $CFG[dbhost]<br>
login: $CFG[dblogin]<br>
password: $CFG[dbpassword]<br>
database: $CFG[database]";
			}
		}
		$json_answer['Translate']['Mess']=iconv('cp1251','utf-8',$json_answer['Translate']['Mess']);
	break;
	case 'checkDir'://проверка доступности папки
		$s=date('Y-m-d H:i:s');
		@file_put_contents("../test.txt",$s);
		$s1=@file_get_contents("../test.txt");
		unlink("../test.txt");
		if($s==$s1){
			//создать папки проекта
			if(!file_exists("../Action")){mkdir("../Action");chmod("../Action",0777);}
			if(!file_exists("../ActionBO")){mkdir("../ActionBO");chmod("../ActionBO",0777);}
			if(!file_exists("../Models")){mkdir("../Models");chmod("../Models",0777);}
			if(!file_exists("../photo")){mkdir("../photo");chmod("../photo",0777);}
			if(!file_exists("../View")){mkdir("../View");chmod("../View",0777);}
			if(!file_exists("../ViewBO")){mkdir("../ViewBO");chmod("../ViewBO",0777);}
			if(!file_exists("../images")){mkdir("../images");chmod("../images",0777);}
			$json_answer['Translate']['Flag']='OK';
			$json_answer['Translate']['Mess']="Корневая папка доступна.";
		}else{
			$json_answer['Translate']['Flag']='Error';
			$json_answer['Translate']['Mess']="Ошибка доступа к корневой папке.";
		}
		$json_answer['Translate']['Mess']=iconv('cp1251','utf-8',$json_answer['Translate']['Mess']);
	break;
	case 'createTables'://создание таблиц
		$json_answer['Translate']['Flag']='OK';
		$json_answer['Translate']['Mess']='';
		foreach ($project['tables'] as $id => $table){
			$json_answer['Translate']['Mess'].="Таблица `$table[name]`<br>";
			
			//надо проверять структуру таблицы, и если совпадает, то не трогать
			if(checkTable($table['name'], $table['fields'])){
				$createError='';
			}else{
				$sql="DROP TABLE IF EXISTS `$table[name]`";
				@mysql_query($sql);
				$dropError=mysql_error();
				$sql="CREATE TABLE `$table[name]` ( `id` int(11) NOT NULL AUTO_INCREMENT, ";
				foreach ($table['fields'] as $field => $fff){
					//echo(chr(9).$field." : ".$fff['type']."<br>");
					$sql.="`$field` ";
					switch($fff['type']){
						case 'int':
						case 'on_off':
							$sql.="int(11)";
						break;
						case 'string':
							$sql.="varchar(255)";
						break;
						case 'date':
							$sql.="datetime";
						break;
						case 'text':
							$sql.="longtext";
						break;
						case 'file':
							$sql.="int(11)";
						break;
					}
					$sql.=" NOT NULL, ";
				}
				$sql.="PRIMARY KEY (`id`));";
				@mysql_query($sql);
			$createError=mysql_error();
			}
			
			if($dropError!=''){
				$json_answer['Translate']['Flag']='Error';
				$json_answer['Translate']['Mess'].=$dropError."<br>";
			}
			if($createError!=''){
				$json_answer['Translate']['Flag']='Error';
				$json_answer['Translate']['Mess'].=$createError."<br>";
			}
		}
		$json_answer['Translate']['Mess']=iconv('cp1251','utf-8',$json_answer['Translate']['Mess']);
	break;
	case 'checkAuthDB'://проверка наличия таблицц для системы авторизации и разделения доступа
		$tablecnt=0;
		$json_answer['Translate']['Flag']='OK';
		$json_answer['Translate']['Mess']='';
		foreach ($project['tables'] as $table){
			switch ($table['name']){
				case 'user':
					if($table['fields']['right']['type']=='int' && $table['fields']['login']['type']=='string' && $table['fields']['password']['type']=='string'){
						$tablecnt++;
						$json_answer['Translate']['Mess'].="Таблица `user` соответствует формату.<br>";
					}else{
						$json_answer['Translate']['Flag']='Error';
						$json_answer['Translate']['Mess'].="Таблица `user` не соответствует формату.<br>";
					}
				break;
				case 'modules':
					if($table['fields']['module']['type']=='string' && $table['fields']['parent']['type']=='int' && $table['fields']['title']['type']=='string' && $table['fields']['type']['type']=='string'){
						$tablecnt++;
						$json_answer['Translate']['Mess'].="Таблица `modules` соответствует формату.<br>";
					}else{
						$json_answer['Translate']['Flag']='Error';
						$json_answer['Translate']['Mess'].="Таблица `modules` не соответствует формату.<br>";
					}
				break;
				case 'right':
					if($table['fields']['name']['type']=='string'){
						$tablecnt++;
						$json_answer['Translate']['Mess'].="Таблица `right` соответствует формату.<br>";
					}else{
						$json_answer['Translate']['Flag']='Error';
						$json_answer['Translate']['Mess'].="Таблица `right` не соответствует формату.<br>";
					}
				break;
				case 'cross_right':
					if($table['fields']['module']['type']=='int' && $table['fields']['right']['type']=='int'){
						$tablecnt++;
						$json_answer['Translate']['Mess'].="Таблица `cross_right` соответствует формату.<br>";
					}else{
						$json_answer['Translate']['Flag']='Error';
						$json_answer['Translate']['Mess'].="Таблица `cross_right` не соответствует формату.<br>";
					}
				break;
				case 'front_user':
					if($table['fields']['right']['type']=='int' && $table['fields']['login']['type']=='string' && $table['fields']['password']['type']=='string'){
						$tablecnt++;
						$json_answer['Translate']['Mess'].="Таблица `front_user` соответствует формату.<br>";
					}else{
						$json_answer['Translate']['Flag']='Error';
						$json_answer['Translate']['Mess'].="Таблица `front_user` не соответствует формату.<br>";
					}
				break;
				case 'front_modules':
					if($table['fields']['module']['type']=='string' && $table['fields']['parent']['type']=='int' && $table['fields']['title']['type']=='string' && $table['fields']['type']['type']=='string'){
						$tablecnt++;
						$json_answer['Translate']['Mess'].="Таблица `front_modules` соответствует формату.<br>";
					}else{
						$json_answer['Translate']['Flag']='Error';
						$json_answer['Translate']['Mess'].="Таблица `front_modules` не соответствует формату.<br>";
					}
				break;
				case 'front_right':
					if($table['fields']['name']['type']=='string'){
						$tablecnt++;
						$json_answer['Translate']['Mess'].="Таблица `front_right` соответствует формату.<br>";
					}else{
						$json_answer['Translate']['Flag']='Error';
						$json_answer['Translate']['Mess'].="Таблица `front_right` не соответствует формату.<br>";
					}
				break;
				case 'front_cross_right':
					if($table['fields']['module']['type']=='int' && $table['fields']['right']['type']=='int'){
						$tablecnt++;
						$json_answer['Translate']['Mess'].="Таблица `front_cross_right` соответствует формату.<br>";
					}else{
						$json_answer['Translate']['Flag']='Error';
						$json_answer['Translate']['Mess'].="Таблица `front_cross_right` не соответствует формату.<br>";
					}
				break;
			}
		}
		//echo($json_answer['Translate']['Mess'].$json_answer['Translate']['Flag']."<br>");
		if($tablecnt<8){
			$json_answer['Translate']['Flag']='Error';
		}
		if($json_answer['Translate']['Flag']=='OK'){
			$_SESSION['AUTH_SYSTEM']=true;
			$json_answer['Translate']['Mess'].="Система авторизации и разделения прав доступа включена";
		}else{
			$_SESSION['AUTH_SYSTEM']=false;
			$json_answer['Translate']['Mess'].="Система авторизации и разделения прав доступа ВЫКЛЮЧЕНА";
		}
		$json_answer['Translate']['Mess']=iconv('cp1251','utf-8',$json_answer['Translate']['Mess']);
	break;
	case 'createAuth'://создание моделей, вьюх и акшинов для системы авторизации и разделения доступа
		if($_SESSION['AUTH_SYSTEM']){
			//библиотека authBO.php для БО
			//библиотека authFO.php для ФО
			makeAuthBlocks();
			$json_answer['Translate']['Flag']='OK';
			$json_answer['Translate']['Mess'].="'Система авторизации и разделения прав доступа.' Код сгенерирован";
		}else{
			$json_answer['Translate']['Flag']='Error';
			$json_answer['Translate']['Mess'].="Система авторизации и разделения прав доступа ВЫКЛЮЧЕНА";
		}
		$json_answer['Translate']['Mess']=iconv('cp1251','utf-8',$json_answer['Translate']['Mess']);
	break;
	case 'createMenuBO'://создание вьюхи меню БО
		copy('scripts/Prototype/bo.php', '../bo.php');
		//$menu=iconv('utf-8','cp1251',serialize($project['front']));
		if($_SESSION['AUTH_SYSTEM']){
			//заполнякем таблицы модулей BO
			mysql_query("TRUNCATE TABLE modules");
			mysql_query("TRUNCATE TABLE cross_right");
			$id_parent=array();
			foreach ($project['back'] as $id => $module){
				//parent, type, name
				$name=iconv('utf-8','cp1251',$module['name']);
				$tname=translit($name);
				if($module['type']=='CRUD' || $module['type']=='TreeCRUD'){
					$id_parent[$id]=array();
					$sql="INSERT INTO modules(module, parent, title, `type`) VALUES('$tname"."ViewBO', 0, '$name', '$module[type]')";
					mysql_query($sql);
					$id_parent[$id][0]=mysql_insert_id();
					//и сразу прописываем права для Anonym
					$sql="INSERT INTO cross_right(module, `right`) VALUES(".$id_parent[$id][0].", 0)";
					mysql_query($sql);
					$sql="INSERT INTO modules(module, parent, title, `type`) VALUES('$tname"."EditBO', 0, '$name', 'edit')";
					mysql_query($sql);
					$id_parent[$id][1]=mysql_insert_id();
					$sql="INSERT INTO cross_right(module, `right`) VALUES(".$id_parent[$id][1].", 0)";
					mysql_query($sql);
					$sql="INSERT INTO modules(module, parent, title, `type`) VALUES('add$tname"."ActionBO', 0, '$name', 'action')";
					mysql_query($sql);
					$id_parent[$id][2]=mysql_insert_id();
					$sql="INSERT INTO cross_right(module, `right`) VALUES(".$id_parent[$id][2].", 0)";
					mysql_query($sql);
					$sql="INSERT INTO modules(module, parent, title, `type`) VALUES('del$tname"."ActionBO', 0, '$name', 'action')";
					mysql_query($sql);
					$id_parent[$id][3]=mysql_insert_id();
					$sql="INSERT INTO cross_right(module, `right`) VALUES(".$id_parent[$id][3].", 0)";
					mysql_query($sql);
					$sql="INSERT INTO modules(module, parent, title, `type`) VALUES('update$tname"."ActionBO', 0, '$name', 'action')";
					mysql_query($sql);
					$id_parent[$id][4]=mysql_insert_id();
					$sql="INSERT INTO cross_right(module, `right`) VALUES(".$id_parent[$id][4].", 0)";
					mysql_query($sql);
				}else{
					$id_parent[$id]=array();
					$sql="INSERT INTO modules(module, parent, title, `type`) VALUES('$tname', 0, '$name', '$module[type]')";
					mysql_query($sql);
					$id_parent[$id][0]=mysql_insert_id();
					$sql="INSERT INTO cross_right(module, `right`) VALUES(".$id_parent[$id][0].", 0)";
					mysql_query($sql);
				}
			}
			foreach ($project['back'] as $id => $module){
				if($module['parent']!=0){
					foreach ($id_parent[$id] as $ii =>$val){
						$sql="UPDATE modules SET parent=".$id_parent[$module['parent']][0]." WHERE id=".$val;
						mysql_query($sql);
					}
				}
			}
			//заполнякем таблицы модулей FO
			$id_parent=array();
			mysql_query("TRUNCATE TABLE front_modules");
			mysql_query("TRUNCATE TABLE front_cross_right");
			foreach ($project['front'] as $id => $module){
				//parent, type, name
				$name=iconv('utf-8','cp1251',$module['name']);
				$tname=translit($name);
				
				if($module['type']=='CRUD' || $module['type']=='TreeCRUD'){
					$id_parent[$id]=array();
					$sql="INSERT INTO front_modules(module, parent, title, `type`) VALUES('$tname"."View', 0, '$name', '$module[type]')";
					mysql_query($sql);
					$id_parent[$id][0]=mysql_insert_id();
					//и сразу прописываем права для Anonym
					$sql="INSERT INTO front_cross_right(module, `right`) VALUES(".$id_parent[$id][0].", 0)";
					mysql_query($sql);
					$sql="INSERT INTO front_modules(module, parent, title, `type`) VALUES('$tname"."Edit', 0, '$name', 'edit')";
					mysql_query($sql);
					$id_parent[$id][1]=mysql_insert_id();
					$sql="INSERT INTO front_cross_right(module, `right`) VALUES(".$id_parent[$id][1].", 0)";
					mysql_query($sql);
					$sql="INSERT INTO front_modules(module, parent, title, `type`) VALUES('add$tname"."Action', 0, '$name', 'action')";
					mysql_query($sql);
					$id_parent[$id][2]=mysql_insert_id();
					$sql="INSERT INTO front_cross_right(module, `right`) VALUES(".$id_parent[$id][2].", 0)";
					mysql_query($sql);
					$sql="INSERT INTO front_modules(module, parent, title, `type`) VALUES('del$tname"."Action', 0, '$name', 'action')";
					mysql_query($sql);
					$id_parent[$id][3]=mysql_insert_id();
					$sql="INSERT INTO front_cross_right(module, `right`) VALUES(".$id_parent[$id][3].", 0)";
					mysql_query($sql);
					$sql="INSERT INTO front_modules(module, parent, title, `type`) VALUES('update$tname"."Action', 0, '$name', 'action')";
					mysql_query($sql);
					$id_parent[$id][4]=mysql_insert_id();
					$sql="INSERT INTO front_cross_right(module, `right`) VALUES(".$id_parent[$id][4].", 0)";
					mysql_query($sql);
				}else{
					$id_parent[$id]=array();
					$sql="INSERT INTO front_modules(module, parent, title, `type`) VALUES('$tname', 0, '$name', '$module[type]')";
					mysql_query($sql);
					$id_parent[$id][0]=mysql_insert_id();
					$sql="INSERT INTO front_cross_right(module, `right`) VALUES(".$id_parent[$id][0].", 0)";
					mysql_query($sql);
				}
			}
			foreach ($project['front'] as $id => $module){
				if($module['parent']!=0){
					foreach ($id_parent[$id] as $ii =>$val){
						$sql="UPDATE front_modules SET parent=".$id_parent[$module['parent']][0]." WHERE id=".$val;
						mysql_query($sql);
					}
				}
			}
			//переносим класс
			$s=file_get_contents('scripts/Prototype/class.menuBO.php');
			file_put_contents('../Models/menuBO.php',$s);
			$json_answer['Translate']['Flag']='OK';
			$json_answer['Translate']['Mess'].="'Главное меню БО' Код сгенерирован";
		}else{
			$json_answer['Translate']['Flag']='Error';
			$json_answer['Translate']['Mess'].="'Главное меню БО' Отказ";
		}
		$json_answer['Translate']['Mess']=iconv('cp1251','utf-8',$json_answer['Translate']['Mess']);
	break;
	case 'createCRUDsBO'://создание моделей для всех CRUD & TreeCRUD БО
		$json_answer['Translate']['Flag']='OK';
		$json_answer['Translate']['Mess']="Models, ViewBO & ActionBO";
		//создаём классы таблиц
		foreach ($project['tables'] as $table){
			$s=makeDBclass($table);
			file_put_contents('../Models/db'.$table['name'].'.php', "<?php
$s
?>");
			checkExceptionFile('scripts/Prototype/exception/db'.$table['name'].'.php', '../Models/db'.$table['name'].'.php');
			$json_answer['Translate']['Mess'].="<br>
db$table[name].php";
		}
		//создаём классы CRUD & TreeCRUD
		foreach ($project['back'] as $pid => $element){
			if($element['type']=='CRUD'){
				$viewName=translit(iconv('utf-8', 'cp1251', $element['name']));
				$s=makeViewCRUDclass($project['back'], $pid, $project['tables']);
				file_put_contents('../ViewBO/'.$viewName.'ViewBO.php', $s);
				checkExceptionFile('scripts/Prototype/exception/'.$viewName.'ViewBO.php', '../ViewBO/'.$viewName.'ViewBO.php');
				$json_answer['Translate']['Mess'].="<br>
".$viewName."ViewBO.php";
				//Создать edit
				$s=makeEditCRUDclass($element, $project['tables']);
				file_put_contents('../ViewBO/'.$viewName.'EditBO.php', $s);
				checkExceptionFile('scripts/Prototype/exception/'.$viewName.'EditBO.php', '../ViewBO/'.$viewName.'EditBO.php');
				$json_answer['Translate']['Mess'].="<br>
".$viewName."EditBO.php";
				//создать ActionBO
				//Add
				$s=makeAddCRUDclass($element, $project['tables']);
				file_put_contents('../ActionBO/add'.$viewName.'ActionBO.php', $s);
				checkExceptionFile('scripts/Prototype/exception/add'.$viewName.'ActionBO.php', '../ActionBO/add'.$viewName.'ActionBO.php');
				$json_answer['Translate']['Mess'].="<br>
add".$viewName."ActionBO.php";
				//Del
				$s=makeDelCRUDclass($element, $project['tables']);
				file_put_contents('../ActionBO/del'.$viewName.'ActionBO.php', $s);
				checkExceptionFile('scripts/Prototype/exception/del'.$viewName.'ActionBO.php', '../ActionBO/del'.$viewName.'ActionBO.php');
				$json_answer['Translate']['Mess'].="<br>
del".$viewName."ActionBO.php";
				//Update
				$s=makeUpdateCRUDclass($element, $project['tables']);
				file_put_contents('../ActionBO/update'.$viewName.'ActionBO.php', $s);
				checkExceptionFile('scripts/Prototype/exception/update'.$viewName.'ActionBO.php', '../ActionBO/update'.$viewName.'ActionBO.php');
				$json_answer['Translate']['Mess'].="<br>
update".$viewName."ActionBO.php";
			}
			if($element['type']=='TreeCRUD'){
				$viewName=translit(iconv('utf-8', 'cp1251', $element['name']));
				$s=makeViewTreeCRUDclass($project['back'], $pid, $project['tables']);
				file_put_contents('../ViewBO/'.$viewName.'ViewBO.php', $s);
				checkExceptionFile('scripts/Prototype/exception/'.$viewName.'ViewBO.php', '../ViewBO/'.$viewName.'ViewBO.php');
				$json_answer['Translate']['Mess'].="<br>
".$viewName."ViewBO.php";
				//Создать edit
				$s=makeEditCRUDclass($element, $project['tables']);
				file_put_contents('../ViewBO/'.$viewName.'EditBO.php', $s);
				checkExceptionFile('scripts/Prototype/exception/'.$viewName.'EditBO.php', '../ViewBO/'.$viewName.'EditBO.php');
				$json_answer['Translate']['Mess'].="<br>
".$viewName."EditBO.php";
				//создать ActionBO
				//Add
				$s=makeAddCRUDclass($element, $project['tables']);
				file_put_contents('../ActionBO/add'.$viewName.'ActionBO.php', $s);
				checkExceptionFile('scripts/Prototype/exception/add'.$viewName.'ActionBO.php', '../ActionBO/add'.$viewName.'ActionBO.php');
				$json_answer['Translate']['Mess'].="<br>
add".$viewName."ActionBO.php";
				//Del
				$s=makeDelCRUDclass($element, $project['tables']);
				file_put_contents('../ActionBO/del'.$viewName.'ActionBO.php', $s);
				checkExceptionFile('scripts/Prototype/exception/del'.$viewName.'ActionBO.php', '../ActionBO/del'.$viewName.'ActionBO.php');
				$json_answer['Translate']['Mess'].="<br>
del".$viewName."ActionBO.php";
				//Update
				$s=makeUpdateCRUDclass($element, $project['tables']);
				file_put_contents('../ActionBO/update'.$viewName.'ActionBO.php', $s);
				checkExceptionFile('scripts/Prototype/exception/update'.$viewName.'ActionBO.php', '../ActionBO/update'.$viewName.'ActionBO.php');
				$json_answer['Translate']['Mess'].="<br>
update".$viewName."ActionBO.php";
			}
		}		
		$json_answer['Translate']['Mess']=iconv('cp1251','utf-8',$json_answer['Translate']['Mess']);
	break;
	case 'createMenuFO'://создание вьюхи меню ФО
		copy('scripts/Prototype/fo.php', '../index.php');
		if($_SESSION['AUTH_SYSTEM']){
			//переносим класс
			$s=file_get_contents('scripts/Prototype/class.menuFO.php');
			file_put_contents('../Models/menuFO.php',$s);
			$json_answer['Translate']['Flag']='OK';
			$json_answer['Translate']['Mess'].="'Главное меню ФО' Код сгенерирован";
		}else{
			$json_answer['Translate']['Flag']='Error';
			$json_answer['Translate']['Mess'].="'Главное меню ФО' Отказ";
		}
		$json_answer['Translate']['Mess']=iconv('cp1251','utf-8',$json_answer['Translate']['Mess']);
	break;
	case 'createCRUDsFO'://создание моделей для всех CRUD & TreeCRUD ФО
		//создаём классы CRUD & TreeCRUD
		$json_answer['Translate']['Flag']='OK';
		$json_answer['Translate']['Mess']="View & Action<br>";
		foreach ($project['front'] as $pid => $element){
			if($element['type']=='CRUD'){
				$viewName=translit(iconv('utf-8', 'cp1251', $element['name']));
				$s=makeViewCRUDclassFO($project['front'], $pid, $project['tables']);
				file_put_contents('../View/'.$viewName.'View.php', $s);
				checkExceptionFile('scripts/Prototype/exception/'.$viewName.'View.php', '../View/'.$viewName.'View.php');
				$json_answer['Translate']['Mess'].="<br>
".$viewName."View.php";
				//Создать edit
				$s=makeEditCRUDclassFO($element, $project['tables']);
				file_put_contents('../View/'.$viewName.'Edit.php', $s);
				checkExceptionFile('scripts/Prototype/exception/'.$viewName.'Edit.php', '../View/'.$viewName.'Edit.php');
				$json_answer['Translate']['Mess'].="<br>
".$viewName."Edit.php";
				//создать ActionFO
				//Add
				$s=makeAddCRUDclassFO($element, $project['tables']);
				file_put_contents('../Action/add'.$viewName.'Action.php', $s);
				checkExceptionFile('scripts/Prototype/exception/add'.$viewName.'Action.php', '../Action/add'.$viewName.'Action.php');
				$json_answer['Translate']['Mess'].="<br>
add".$viewName."Action.php";
				//Del
				$s=makeDelCRUDclassFO($element, $project['tables']);
				file_put_contents('../Action/del'.$viewName.'Action.php', $s);
				checkExceptionFile('scripts/Prototype/exception/del'.$viewName.'Action.php', '../Action/del'.$viewName.'Action.php');
				$json_answer['Translate']['Mess'].="<br>
del".$viewName."Action.php";
				//Update
				$s=makeUpdateCRUDclassFO($element, $project['tables']);
				file_put_contents('../Action/update'.$viewName.'Action.php', $s);
				checkExceptionFile('scripts/Prototype/exception/update'.$viewName.'Action.php', '../Action/update'.$viewName.'Action.php');
				$json_answer['Translate']['Mess'].="<br>
update".$viewName."Action.php";
			}
			if($element['type']=='TreeCRUD'){
				$viewName=translit(iconv('utf-8', 'cp1251', $element['name']));
				$s=makeViewTreeCRUDclassFO($project['front'], $pid, $project['tables']);
				file_put_contents('../View/'.$viewName.'View.php', $s);
				checkExceptionFile('scripts/Prototype/exception/'.$viewName.'View.php', '../View/'.$viewName.'View.php');
				$json_answer['Translate']['Mess'].="<br>
".$viewName."View.php";
				//Создать edit
				$s=makeEditCRUDclassFO($element, $project['tables']);
				file_put_contents('../View/'.$viewName.'Edit.php', $s);
				checkExceptionFile('scripts/Prototype/exception/'.$viewName.'Edit.php', '../View/'.$viewName.'Edit.php');
				$json_answer['Translate']['Mess'].="<br>
".$viewName."Edit.php";
				//создать Action
				//Add
				$s=makeAddCRUDclassFO($element, $project['tables']);
				file_put_contents('../Action/add'.$viewName.'Action.php', $s);
				checkExceptionFile('scripts/Prototype/exception/add'.$viewName.'Action.php', '../Action/add'.$viewName.'Action.php');
				$json_answer['Translate']['Mess'].="<br>
add".$viewName."Action.php";
				//Del
				$s=makeDelCRUDclassFO($element, $project['tables']);
				file_put_contents('../Action/del'.$viewName.'Action.php', $s);
				checkExceptionFile('scripts/Prototype/exception/del'.$viewName.'Action.php', '../Action/del'.$viewName.'Action.php');
				$json_answer['Translate']['Mess'].="<br>
del".$viewName."Action.php";
				//Update
				$s=makeUpdateCRUDclassFO($element, $project['tables']);
				file_put_contents('../Action/update'.$viewName.'Action.php', $s);
				checkExceptionFile('scripts/Prototype/exception/update'.$viewName.'Action.php', '../Action/update'.$viewName.'Action.php');
				$json_answer['Translate']['Mess'].="<br>
update".$viewName."Action.php";
			}
		}
		
		//регистрационные формы
		$s=makeRegistrFormBO($project['tables']);
		file_put_contents('../ViewBO/registrFormViewBO.php', $s);
		$json_answer['Translate']['Mess'].="<br>registrFormViewBO.php";
		$sql="INSERT INTO modules(module, parent, title, `type`) VALUES('registrFormViewBO', 0, 'registrFormViewBO', 'crud')";
		mysql_query($sql);
		$id=mysql_insert_id();
		$sql="INSERT INTO cross_right(module, `right`) VALUES($id, 0)";
		mysql_query($sql);
		
		$s=makeRegistredFormBO($project['tables']);
		file_put_contents('../ViewBO/registredFormViewBO.php', $s);
		$json_answer['Translate']['Mess'].="<br>registredFormViewBO.php";
		$sql="INSERT INTO modules(module, parent, title, `type`) VALUES('registredFormViewBO', 0, 'registredFormViewBO', 'crud')";
		mysql_query($sql);
		$id=mysql_insert_id();
		$sql="INSERT INTO cross_right(module, `right`) VALUES($id, 0)";
		mysql_query($sql);
		
		$s=makeActionRegistrBO($project['tables']);
		file_put_contents('../ActionBO/registrFormActionBO.php', $s);
		$json_answer['Translate']['Mess'].="<br>registrFormActionBO.php";
		$sql="INSERT INTO modules(module, parent, title, `type`) VALUES('registrFormActionBO', 0, 'registrFormActionBO', 'action')";
		mysql_query($sql);
		$id=mysql_insert_id();
		$sql="INSERT INTO cross_right(module, `right`) VALUES($id, 0)";
		mysql_query($sql);
		
		$s=makeRegistrFormFO($project['tables']);
		file_put_contents('../View/registrFormView.php', $s);
		$json_answer['Translate']['Mess'].="<br>registrFormView.php";
		$sql="INSERT INTO front_modules(module, parent, title, `type`) VALUES('registrFormView', 0, 'registrFormView', 'crud')";
		mysql_query($sql);
		$id=mysql_insert_id();
		$sql="INSERT INTO front_cross_right(module, `right`) VALUES($id, 0)";
		mysql_query($sql);
		
		$s=makeRegistredFormFO($project['tables']);
		file_put_contents('../View/registredFormView.php', $s);
		$json_answer['Translate']['Mess'].="<br>registredFormView.php";
		$sql="INSERT INTO front_modules(module, parent, title, `type`) VALUES('registredFormView', 0, 'registredFormView', 'crud')";
		mysql_query($sql);
		$id=mysql_insert_id();
		$sql="INSERT INTO front_cross_right(module, `right`) VALUES($id, 0)";
		mysql_query($sql);
		
		$s=makeActionRegistrFO($project['tables']);
		file_put_contents('../Action/registrFormAction.php', $s);
		$json_answer['Translate']['Mess'].="<br>registrFormAction.php";
		$sql="INSERT INTO front_modules(module, parent, title, `type`) VALUES('registrFormAction', 0, 'registrFormAction', 'action')";
		mysql_query($sql);
		$id=mysql_insert_id();
		$sql="INSERT INTO front_cross_right(module, `right`) VALUES($id, 0)";
		mysql_query($sql);
		
		$json_answer['Translate']['Mess']=iconv('cp1251','utf-8',$json_answer['Translate']['Mess']);
	break;
}
echo("(".json_encode($json_answer).")");


function checkTable($table, $fields){
//	$fp=fopen('3.txt','a');
	
	$sql="desc `$table`";
	$r=mysql_query($sql);
	$n=mysql_num_rows($r);
	/*
fputs($fp, $sql."
".mysql_error()."
n=$n
");
*/
	if($n>0){$res=true;}else{$res=false;}
	for($i=0;$i<$n;$i++){
		$Field=mysql_result($r,$i,'Field');
		$Type=mysql_result($r,$i,'Type');
		$Null=mysql_result($r,$i,'Null');
		$Key=mysql_result($r,$i,'Key');
		$Default=mysql_result($r,$i,'Default');
		$Extra=mysql_result($r,$i,'Extra');
		
		$NewType='string';
		$p0=strpos($Type,'int');
		if($p0!==false){$NewType='int';}
		$p0=strpos($Type,'text');
		if($p0!==false){$NewType='text';}
		$p0=strpos($Type,'data');
		if($p0!==false){$NewType='data';}
		
		if($Field!='id'){
/*
fputs($fp, "'$Field' : '".$fields[$Field]['type']."'=='".$NewType."'
");
*/
			if(isset($fields[$Field]) &&
			 ($fields[$Field]['type']==$NewType || 
			 ($fields[$Field]['type']=='file') && ($NewType=='int'))
			 ){}else{
				$res=false;
			}
		}
	}
/*
if($res){
	fputs($fp,'1
');
}else{
	fputs($fp,'0
');
}
*/
	//fclose($fp);
	return $res;
}
function checkExceptionFile($exceptionFile, $classFile){
	if(file_exists($exceptionFile)){
		copy($exceptionFile, $classFile);
	}
}
?>