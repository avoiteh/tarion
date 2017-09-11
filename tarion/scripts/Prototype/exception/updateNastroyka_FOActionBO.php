<?php
class updateNastroyka_FOActionBO{
	function Go(){
		//создаём объекты доступа к таблицам
		$dbfront_cross_right=new dbfront_cross_right();
		$dbfront_modules = new dbfront_modules();
		$front_listmodules=$dbfront_modules->load('','',0,0);
		$dbfront_right = new dbfront_right();
		$front_listright=$dbfront_right->load('','',0,0);
		$front_listcross_right=$dbfront_cross_right->load('', '', 0, 0);
		foreach ($front_listmodules as $module){
			//$module['module']
			foreach ($front_listright as $rec){
				$name="cross_".$module['module']."_".$rec['name'];
				if($_REQUEST[$name]=='on'){
					//добавить запись в кросс
					$dbfront_cross_right->add($module['id'],$rec['id']);
				}else{
					//удалить запись из кросса
					$dbfront_cross_right->delByModuleRight($module['id'],$rec['id']);
				}
			}
		}
	}
}
?>