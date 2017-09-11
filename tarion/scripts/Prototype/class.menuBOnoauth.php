<?php
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
?>