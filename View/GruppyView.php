<?php
class GruppyView{
	var $dbgruppa;
	var $listgruppa;
var $dbtop_spec;
var $listtop_spec;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function GruppyView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Gruppy'])){
			$_SESSION['Gruppy']['filter']=array();
			$_SESSION['Gruppy']['filter_check']=array();
			$_SESSION['Gruppy']['page']=1;
			$_SESSION['Gruppy']['limit']=100;
			$_SESSION['Gruppy']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Gruppy']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Gruppy']['datafields']=array();
$_SESSION['Gruppy']['datafields']['special']='int';
$_SESSION['Gruppy']['filter']['special'] = mysql_escape_string($_REQUEST['filter']['special']);
$_SESSION['Gruppy']['filter_check']['special'] = $_REQUEST['filter_check']['special'] == 'on';
$_SESSION['Gruppy']['datafields']['kurs']='int';
$_SESSION['Gruppy']['filter']['kurs'] = mysql_escape_string($_REQUEST['filter']['kurs']);
$_SESSION['Gruppy']['filter_check']['kurs'] = $_REQUEST['filter_check']['kurs'] == 'on';
$_SESSION['Gruppy']['filter']['sozdan_from'] = mysql_escape_string($_REQUEST['filter']['sozdan_from']);
$_SESSION['Gruppy']['filter_check']['sozdan_from'] = $_REQUEST['filter_check']['sozdan_from'] == 'on';
$_SESSION['Gruppy']['datafields']['sozdan_from']='from';
$_SESSION['Gruppy']['filter']['sozdan_to'] = mysql_escape_string($_REQUEST['filter']['sozdan_to']);
$_SESSION['Gruppy']['filter_check']['sozdan_to'] = $_REQUEST['filter_check']['sozdan_to'] == 'on';
$_SESSION['Gruppy']['datafields']['sozdan_to']='to';
$_SESSION['Gruppy']['datafields']['status']='on_off';
$_SESSION['Gruppy']['filter']['status'] = mysql_escape_string($_REQUEST['filter']['status']);
$_SESSION['Gruppy']['filter_check']['status'] = $_REQUEST['filter_check']['status'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Gruppy']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Gruppy']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Gruppy']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Gruppy']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Gruppy']['filter'];
		$this->filter_check=$_SESSION['Gruppy']['filter_check'];
		$this->start=$_SESSION['Gruppy']['page'];
		$this->limit=$_SESSION['Gruppy']['limit'];
		$this->order=$_SESSION['Gruppy']['order'];
		//создаём объекты доступа к таблицам
		$this->dbgruppa=new dbgruppa();
$this->dbtop_spec = new dbtop_spec();
//получаем лист для lookUp
		$this->listtop_spec=$this->dbtop_spec->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Gruppy']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Gruppy']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Gruppy']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbgruppa->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listgruppa=$this->dbgruppa->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?>
<form action='?view=GruppyView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[special]' <?php if($this->filter_check['special']){ echo(" checked");}?> value='on'>special:<br><?php echo($this->lookUpList($this->listtop_spec, $this->filter['special'], 'topspec', 'filter[special]'));?></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[kurs]' <?php if($this->filter_check['kurs']){ echo(" checked");}?> value='on'>kurs:<br><input class=filter type=text name='filter[kurs]' value='<?php echo($this->filter['kurs']);?>'></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[sozdan_from]' <?php if($this->filter_check['sozdan_from']){ echo(" checked");}?> value='on'>sozdan_from:<br><input class=filter type=text id='filter_sozdan_from_fd' name='filter[sozdan_from]' value='<?php echo($this->filter['sozdan_from']);?>'><img src='images/b_calendar.png' onclick="openCalendar('', '', 'filter_sozdan_from_fd', 'datetime', 'filter_sozdan_from_fd');"><br><input type='checkbox' name='filter_check[sozdan_to]' <?php if($this->filter_check['sozdan_to']){ echo(" checked");}?> value='on'>sozdan_to:<br><input class=filter type=text id='filter_sozdan_to_fd' name='filter[sozdan_to]' value='<?php echo($this->filter['sozdan_to']);?>'><img src='images/b_calendar.png' onclick="openCalendar('', '', 'filter_sozdan_to_fd', 'datetime', 'filter_sozdan_to_fd');"></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[status]' <?php if($this->filter_check['status']){ echo(" checked");}?> value='on'>status:<br><input type=checkbox name='filter[status]' value='on' <?php if($this->filter['status']!=0){?> checked<?php }?>'></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=GruppyView&action=addGruppyAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>ID</td>
<td>gruppa</td>
<td>special</td>
<td>kurs</td>
<td>sozdan</td>
<td>status</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listgruppa as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['id']);?></td>
	<td><?php echo($onerec['gruppa']);?></td>
	<td><?php echo($this->lookUp($this->listtop_spec, $onerec['special'], 'topspec'));?></td>
	<td><?php echo($onerec['kurs']);?></td>
	<td><?php echo($onerec['sozdan']);?></td>
	<td><?php if($onerec['status']!=0){?>ON<?php }else{?>OFF<?php }?></td>
	<td><a href='?view=GruppyEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=GruppyView&action=delGruppyAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=GruppyView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>