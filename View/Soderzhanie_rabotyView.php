<?php
class Soderzhanie_rabotyView{
	var $dbprotokol_cont;
	var $listprotokol_cont;
var $dbppr;
var $listppr;
var $dbprotokols;
var $listprotokols;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function Soderzhanie_rabotyView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Soderzhanie_raboty'])){
			$_SESSION['Soderzhanie_raboty']['filter']=array();
			$_SESSION['Soderzhanie_raboty']['filter_check']=array();
			$_SESSION['Soderzhanie_raboty']['page']=1;
			$_SESSION['Soderzhanie_raboty']['limit']=100;
			$_SESSION['Soderzhanie_raboty']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Soderzhanie_raboty']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Soderzhanie_raboty']['datafields']=array();
$_SESSION['Soderzhanie_raboty']['datafields']['preprab']='int';
$_SESSION['Soderzhanie_raboty']['filter']['preprab'] = mysql_escape_string($_REQUEST['filter']['preprab']);
$_SESSION['Soderzhanie_raboty']['filter_check']['preprab'] = $_REQUEST['filter_check']['preprab'] == 'on';
$_SESSION['Soderzhanie_raboty']['datafields']['protokol']='int';
$_SESSION['Soderzhanie_raboty']['filter']['protokol'] = mysql_escape_string($_REQUEST['filter']['protokol']);
$_SESSION['Soderzhanie_raboty']['filter_check']['protokol'] = $_REQUEST['filter_check']['protokol'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Soderzhanie_raboty']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Soderzhanie_raboty']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Soderzhanie_raboty']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Soderzhanie_raboty']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Soderzhanie_raboty']['filter'];
		$this->filter_check=$_SESSION['Soderzhanie_raboty']['filter_check'];
		$this->start=$_SESSION['Soderzhanie_raboty']['page'];
		$this->limit=$_SESSION['Soderzhanie_raboty']['limit'];
		$this->order=$_SESSION['Soderzhanie_raboty']['order'];
		//создаём объекты доступа к таблицам
		$this->dbprotokol_cont=new dbprotokol_cont();
$this->dbppr = new dbppr();
//получаем лист для lookUp
		$this->listppr=$this->dbppr->load('','',0,0);$this->dbprotokols = new dbprotokols();
//получаем лист для lookUp
		$this->listprotokols=$this->dbprotokols->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Soderzhanie_raboty']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Soderzhanie_raboty']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Soderzhanie_raboty']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbprotokol_cont->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listprotokol_cont=$this->dbprotokol_cont->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?><a href='?view=Protokoly_soderzhanieView'>&lt;&lt;&lt;&lt; Назад</br>
<form action='?view=Soderzhanie_rabotyView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[preprab]' <?php if($this->filter_check['preprab']){ echo(" checked");}?> value='on'>preprab:<br><?php echo($this->lookUpList($this->listppr, $this->filter['preprab'], 'razdel', 'filter[preprab]'));?></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[protokol]' <?php if($this->filter_check['protokol']){ echo(" checked");}?> value='on'>protokol:<br><?php echo($this->lookUpList($this->listprotokols, $this->filter['protokol'], 'komis', 'filter[protokol]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=Soderzhanie_rabotyView&action=addSoderzhanie_rabotyAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>preprab</td>
<td>protokol</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listprotokol_cont as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($this->lookUp($this->listppr, $onerec['preprab'], 'razdel'));?></td>
	<td><?php echo($this->lookUp($this->listprotokols, $onerec['protokol'], 'komis'));?></td>
	<td><a href='?view=Soderzhanie_rabotyEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=Soderzhanie_rabotyView&action=delSoderzhanie_rabotyAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
</tr><?php
			if($col=='eeeeee'){$col='dddddd';}else{$col='eeeeee';}
		}
?>
</table>
Страница: <?php
		$this->shkala();
	}
	function lookUp(&$list, $id, $field_name){
		$res=false;
		$fna=explode(":",$field_name);
		foreach ($list as $rec){
			if($rec['id']==$id){
				$res='';
				foreach ($fna as $ofn){
					$res.=$rec[$ofn].' ';
				}
			}
		}
		return $res;
	}
	function lookUpList(&$list, $id, $field_name, $name){
		$s="<select name='$name'>
		<option value=0> --- </option>
";
		$fna=explode(':',$field_name);
		if(is_array($list)){
			foreach ($list as $rec){
				$s.="<option value='".$rec['id']."'";
				if($rec['id']==$id){
					$s.=" selected";
				}
				$s.=">";
				foreach ($fna as $ofn){
					$s.=$rec[$ofn].' ';
				}
				$s.="</option>
";
			}
		}
		$s.="</select>
";
		return $s;
	}
	function longText($s, $len=50){
		if(strlen($s)>$len){
			return substr($s,0,$len).'...';
		}else{
			return $s;
		}
	}
	function photo($photo, $name){
		$path=photoPath($photo).'/'.$name;
		if(file_exists($path)){
			return "<img src='$path'>";
		}else{
			return "<img src='./photo/noimage.png'>";
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
				?><a href='?view=Soderzhanie_rabotyView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>