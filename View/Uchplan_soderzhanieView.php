<?php
class Uchplan_soderzhanieView{
	var $dbuch_cont;
	var $listuch_cont;
var $dbprepod_plan;
var $listprepod_plan;
var $dbpredmet;
var $listpredmet;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function Uchplan_soderzhanieView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Uchplan_soderzhanie'])){
			$_SESSION['Uchplan_soderzhanie']['filter']=array();
			$_SESSION['Uchplan_soderzhanie']['filter_check']=array();
			$_SESSION['Uchplan_soderzhanie']['page']=1;
			$_SESSION['Uchplan_soderzhanie']['limit']=100;
			$_SESSION['Uchplan_soderzhanie']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Uchplan_soderzhanie']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Uchplan_soderzhanie']['datafields']=array();
$_SESSION['Uchplan_soderzhanie']['datafields']['plann']='int';
$_SESSION['Uchplan_soderzhanie']['filter']['plann'] = mysql_escape_string($_REQUEST['filter']['plann']);
$_SESSION['Uchplan_soderzhanie']['filter_check']['plann'] = $_REQUEST['filter_check']['plann'] == 'on';
$_SESSION['Uchplan_soderzhanie']['datafields']['predmet']='int';
$_SESSION['Uchplan_soderzhanie']['filter']['predmet'] = mysql_escape_string($_REQUEST['filter']['predmet']);
$_SESSION['Uchplan_soderzhanie']['filter_check']['predmet'] = $_REQUEST['filter_check']['predmet'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Uchplan_soderzhanie']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Uchplan_soderzhanie']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Uchplan_soderzhanie']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Uchplan_soderzhanie']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Uchplan_soderzhanie']['filter'];
		$this->filter_check=$_SESSION['Uchplan_soderzhanie']['filter_check'];
		$this->start=$_SESSION['Uchplan_soderzhanie']['page'];
		$this->limit=$_SESSION['Uchplan_soderzhanie']['limit'];
		$this->order=$_SESSION['Uchplan_soderzhanie']['order'];
		//создаём объекты доступа к таблицам
		$this->dbuch_cont=new dbuch_cont();
$this->dbprepod_plan = new dbprepod_plan();
//получаем лист для lookUp
		$this->listprepod_plan=$this->dbprepod_plan->load('','',0,0);$this->dbpredmet = new dbpredmet();
//получаем лист для lookUp
		$this->listpredmet=$this->dbpredmet->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Uchplan_soderzhanie']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Uchplan_soderzhanie']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Uchplan_soderzhanie']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbuch_cont->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listuch_cont=$this->dbuch_cont->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?><a href='?view=UchplanView'>&lt;&lt;&lt;&lt; Назад</br>
<form action='?view=Uchplan_soderzhanieView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[plann]' <?php if($this->filter_check['plann']){ echo(" checked");}?> value='on'>plann:<br><?php echo($this->lookUpList($this->listprepod_plan, $this->filter['plann'], 'remark', 'filter[plann]'));?></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[predmet]' <?php if($this->filter_check['predmet']){ echo(" checked");}?> value='on'>predmet:<br><?php echo($this->lookUpList($this->listpredmet, $this->filter['predmet'], 'predmet', 'filter[predmet]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=Uchplan_soderzhanieView&action=addUchplan_soderzhanieAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>plann</td>
<td>indexplan</td>
<td>predmet</td>
<td>theory</td>
<td>praktik</td>
<td>kursov</td>
<td>samost</td>
<td>kolvokontrol</td>
<td>chassem1</td>
<td>chassem2</td>
<td>chassem3</td>
<td>chassem4</td>
<td>chassem5</td>
<td>chassem6</td>
<td>chassem7</td>
<td>chassem8</td>
<td>zachsem1</td>
<td>zachsem2</td>
<td>zachsem3</td>
<td>zachsem4</td>
<td>zachsem5</td>
<td>zachsem6</td>
<td>zachsem7</td>
<td>zachsem8</td>
<td>kurssem1</td>
<td>kurssem2</td>
<td>kurssem3</td>
<td>kurssem4</td>
<td>kurssem5</td>
<td>kurssem6</td>
<td>kurssem7</td>
<td>kurssem8</td>
<td>kontrsem1</td>
<td>kontrsem2</td>
<td>kontrsem3</td>
<td>kontrsem4</td>
<td>kontrsem5</td>
<td>kontrsem6</td>
<td>kontrsem7</td>
<td>kontrsem8</td>
<td>examsem1</td>
<td>examsem2</td>
<td>examsem3</td>
<td>examsem4</td>
<td>examsem5</td>
<td>examsem6</td>
<td>examsem7</td>
<td>examsem8</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listuch_cont as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($this->lookUp($this->listprepod_plan, $onerec['plann'], 'remark'));?></td>
	<td><?php echo($onerec['indexplan']);?></td>
	<td><?php echo($this->lookUp($this->listpredmet, $onerec['predmet'], 'predmet'));?></td>
	<td><?php echo($onerec['theory']);?></td>
	<td><?php echo($onerec['praktik']);?></td>
	<td><?php echo($onerec['kursov']);?></td>
	<td><?php echo($onerec['samost']);?></td>
	<td><?php echo($onerec['kolvokontrol']);?></td>
	<td><?php echo($onerec['chassem1']);?></td>
	<td><?php echo($onerec['chassem2']);?></td>
	<td><?php echo($onerec['chassem3']);?></td>
	<td><?php echo($onerec['chassem4']);?></td>
	<td><?php echo($onerec['chassem5']);?></td>
	<td><?php echo($onerec['chassem6']);?></td>
	<td><?php echo($onerec['chassem7']);?></td>
	<td><?php echo($onerec['chassem8']);?></td>
	<td><?php echo($onerec['zachsem1']);?></td>
	<td><?php echo($onerec['zachsem2']);?></td>
	<td><?php echo($onerec['zachsem3']);?></td>
	<td><?php echo($onerec['zachsem4']);?></td>
	<td><?php echo($onerec['zachsem5']);?></td>
	<td><?php echo($onerec['zachsem6']);?></td>
	<td><?php echo($onerec['zachsem7']);?></td>
	<td><?php echo($onerec['zachsem8']);?></td>
	<td><?php echo($onerec['kurssem1']);?></td>
	<td><?php echo($onerec['kurssem2']);?></td>
	<td><?php echo($onerec['kurssem3']);?></td>
	<td><?php echo($onerec['kurssem4']);?></td>
	<td><?php echo($onerec['kurssem5']);?></td>
	<td><?php echo($onerec['kurssem6']);?></td>
	<td><?php echo($onerec['kurssem7']);?></td>
	<td><?php echo($onerec['kurssem8']);?></td>
	<td><?php echo($onerec['kontrsem1']);?></td>
	<td><?php echo($onerec['kontrsem2']);?></td>
	<td><?php echo($onerec['kontrsem3']);?></td>
	<td><?php echo($onerec['kontrsem4']);?></td>
	<td><?php echo($onerec['kontrsem5']);?></td>
	<td><?php echo($onerec['kontrsem6']);?></td>
	<td><?php echo($onerec['kontrsem7']);?></td>
	<td><?php echo($onerec['kontrsem8']);?></td>
	<td><?php echo($onerec['examsem1']);?></td>
	<td><?php echo($onerec['examsem2']);?></td>
	<td><?php echo($onerec['examsem3']);?></td>
	<td><?php echo($onerec['examsem4']);?></td>
	<td><?php echo($onerec['examsem5']);?></td>
	<td><?php echo($onerec['examsem6']);?></td>
	<td><?php echo($onerec['examsem7']);?></td>
	<td><?php echo($onerec['examsem8']);?></td>
	<td><a href='?view=Uchplan_soderzhanieEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=Uchplan_soderzhanieView&action=delUchplan_soderzhanieAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=Uchplan_soderzhanieView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>