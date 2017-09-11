<?php
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