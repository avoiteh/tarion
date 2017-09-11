<?php
class updateNastroyka_BOActionBO{
	function Go(){
		//создаём объекты доступа к таблицам
		$dbcross_right=new dbcross_right();
		$dbmodules = new dbmodules();
		$listmodules=$dbmodules->load('','',0,0);
		$dbright = new dbright();
		$listright=$dbright->load('','',0,0);
		$listcross_right=$dbcross_right->load('', '', 0, 0);
		foreach ($listmodules as $module){
			//$module['module']
			foreach ($listright as $rec){
				$name="cross_".$module['module']."_".$rec['name'];
				if($_REQUEST[$name]=='on'){
					//добавить запись в кросс
					$dbcross_right->add($module['id'],$rec['id']);
				}else{
					//удалить запись из кросса
					$dbcross_right->delByModuleRight($module['id'],$rec['id']);
				}
			}
		}
	}
}
?>