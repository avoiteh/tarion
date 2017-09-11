<?php
class Plan_prep__soderzhanieView{
	var $dbprepod_cont;
	var $listprepod_cont;
var $dbprepod_plan;
var $listprepod_plan;
var $dbppr;
var $listppr;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function Plan_prep__soderzhanieView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Plan_prep__soderzhanie'])){
			$_SESSION['Plan_prep__soderzhanie']['filter']=array();
			$_SESSION['Plan_prep__soderzhanie']['filter_check']=array();
			$_SESSION['Plan_prep__soderzhanie']['page']=1;
			$_SESSION['Plan_prep__soderzhanie']['limit']=100;
			$_SESSION['Plan_prep__soderzhanie']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Plan_prep__soderzhanie']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Plan_prep__soderzhanie']['datafields']=array();
$_SESSION['Plan_prep__soderzhanie']['datafields']['plann']='int';
$_SESSION['Plan_prep__soderzhanie']['filter']['plann'] = mysql_escape_string($_REQUEST['filter']['plann']);
$_SESSION['Plan_prep__soderzhanie']['filter_check']['plann'] = $_REQUEST['filter_check']['plann'] == 'on';
$_SESSION['Plan_prep__soderzhanie']['datafields']['tip']='int';
$_SESSION['Plan_prep__soderzhanie']['filter']['tip'] = mysql_escape_string($_REQUEST['filter']['tip']);
$_SESSION['Plan_prep__soderzhanie']['filter_check']['tip'] = $_REQUEST['filter_check']['tip'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Plan_prep__soderzhanie']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Plan_prep__soderzhanie']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Plan_prep__soderzhanie']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Plan_prep__soderzhanie']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Plan_prep__soderzhanie']['filter'];
		$this->filter_check=$_SESSION['Plan_prep__soderzhanie']['filter_check'];
		$this->start=$_SESSION['Plan_prep__soderzhanie']['page'];
		$this->limit=$_SESSION['Plan_prep__soderzhanie']['limit'];
		$this->order=$_SESSION['Plan_prep__soderzhanie']['order'];
		//создаём объекты доступа к таблицам
		$this->dbprepod_cont=new dbprepod_cont();
$this->dbprepod_plan = new dbprepod_plan();
//получаем лист для lookUp
		$this->listprepod_plan=$this->dbprepod_plan->load('','',0,0);$this->dbppr = new dbppr();
//получаем лист для lookUp
		$this->listppr=$this->dbppr->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Plan_prep__soderzhanie']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Plan_prep__soderzhanie']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Plan_prep__soderzhanie']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbprepod_cont->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listprepod_cont=$this->dbprepod_cont->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?><a href='?view=Komissiya_plana_rab__prep_View'>&lt;&lt;&lt;&lt; Назад</br>
<form action='?view=Plan_prep__soderzhanieView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[plann]' <?php if($this->filter_check['plann']){ echo(" checked");}?> value='on'>plann:<br><?php echo($this->lookUpList($this->listprepod_plan, $this->filter['plann'], 'remark', 'filter[plann]'));?></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[tip]' <?php if($this->filter_check['tip']){ echo(" checked");}?> value='on'>tip:<br><?php echo($this->lookUpList($this->listppr, $this->filter['tip'], 'razdel', 'filter[tip]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=Plan_prep__soderzhanieView&action=addPlan_prep__soderzhanieAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>plann</td>
<td>tip</td>
<td>opis</td>
<td>srok</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listprepod_cont as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($this->lookUp($this->listprepod_plan, $onerec['plann'], 'remark'));?></td>
	<td><?php echo($this->lookUp($this->listppr, $onerec['tip'], 'razdel'));?></td>
	<td><?php echo($onerec['opis']);?></td>
	<td><?php echo($onerec['srok']);?></td>
	<td><a href='?view=Plan_prep__soderzhanieEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=Plan_prep__soderzhanieView&action=delPlan_prep__soderzhanieAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=Plan_prep__soderzhanieView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>