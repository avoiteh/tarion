<?php
class UchashchiesyaView{
	var $dbuchenik;
	var $listuchenik;
var $dbgruppa;
var $listgruppa;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function UchashchiesyaView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Uchashchiesya'])){
			$_SESSION['Uchashchiesya']['filter']=array();
			$_SESSION['Uchashchiesya']['filter_check']=array();
			$_SESSION['Uchashchiesya']['page']=1;
			$_SESSION['Uchashchiesya']['limit']=100;
			$_SESSION['Uchashchiesya']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Uchashchiesya']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Uchashchiesya']['datafields']=array();
$_SESSION['Uchashchiesya']['datafields']['family']='string';
$_SESSION['Uchashchiesya']['filter']['family'] = mysql_escape_string($_REQUEST['filter']['family']);
$_SESSION['Uchashchiesya']['filter_check']['family'] = $_REQUEST['filter_check']['family'] == 'on';
$_SESSION['Uchashchiesya']['datafields']['name']='string';
$_SESSION['Uchashchiesya']['filter']['name'] = mysql_escape_string($_REQUEST['filter']['name']);
$_SESSION['Uchashchiesya']['filter_check']['name'] = $_REQUEST['filter_check']['name'] == 'on';
$_SESSION['Uchashchiesya']['datafields']['otch']='string';
$_SESSION['Uchashchiesya']['filter']['otch'] = mysql_escape_string($_REQUEST['filter']['otch']);
$_SESSION['Uchashchiesya']['filter_check']['otch'] = $_REQUEST['filter_check']['otch'] == 'on';
$_SESSION['Uchashchiesya']['datafields']['gruppa']='int';
$_SESSION['Uchashchiesya']['filter']['gruppa'] = mysql_escape_string($_REQUEST['filter']['gruppa']);
$_SESSION['Uchashchiesya']['filter_check']['gruppa'] = $_REQUEST['filter_check']['gruppa'] == 'on';
$_SESSION['Uchashchiesya']['datafields']['kurszach']='int';
$_SESSION['Uchashchiesya']['filter']['kurszach'] = mysql_escape_string($_REQUEST['filter']['kurszach']);
$_SESSION['Uchashchiesya']['filter_check']['kurszach'] = $_REQUEST['filter_check']['kurszach'] == 'on';
$_SESSION['Uchashchiesya']['filter']['datarozhd_from'] = mysql_escape_string($_REQUEST['filter']['datarozhd_from']);
$_SESSION['Uchashchiesya']['filter_check']['datarozhd_from'] = $_REQUEST['filter_check']['datarozhd_from'] == 'on';
$_SESSION['Uchashchiesya']['datafields']['datarozhd_from']='from';
$_SESSION['Uchashchiesya']['filter']['datarozhd_to'] = mysql_escape_string($_REQUEST['filter']['datarozhd_to']);
$_SESSION['Uchashchiesya']['filter_check']['datarozhd_to'] = $_REQUEST['filter_check']['datarozhd_to'] == 'on';
$_SESSION['Uchashchiesya']['datafields']['datarozhd_to']='to';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Uchashchiesya']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Uchashchiesya']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Uchashchiesya']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Uchashchiesya']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Uchashchiesya']['filter'];
		$this->filter_check=$_SESSION['Uchashchiesya']['filter_check'];
		$this->start=$_SESSION['Uchashchiesya']['page'];
		$this->limit=$_SESSION['Uchashchiesya']['limit'];
		$this->order=$_SESSION['Uchashchiesya']['order'];
		//создаём объекты доступа к таблицам
		$this->dbuchenik=new dbuchenik();
$this->dbgruppa = new dbgruppa();
//получаем лист для lookUp
		$this->listgruppa=$this->dbgruppa->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Uchashchiesya']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Uchashchiesya']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Uchashchiesya']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbuchenik->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listuchenik=$this->dbuchenik->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?>
<form action='?view=UchashchiesyaView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[family]' <?php if($this->filter_check['family']){ echo(" checked");}?> value='on'>family:<br><input class=filter type=text name='filter[family]' value='<?php echo($this->filter['family']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[name]' <?php if($this->filter_check['name']){ echo(" checked");}?> value='on'>name:<br><input class=filter type=text name='filter[name]' value='<?php echo($this->filter['name']);?>'></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[otch]' <?php if($this->filter_check['otch']){ echo(" checked");}?> value='on'>otch:<br><input class=filter type=text name='filter[otch]' value='<?php echo($this->filter['otch']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[gruppa]' <?php if($this->filter_check['gruppa']){ echo(" checked");}?> value='on'>gruppa:<br><?php echo($this->lookUpList($this->listgruppa, $this->filter['gruppa'], 'gruppa', 'filter[gruppa]'));?></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[kurszach]' <?php if($this->filter_check['kurszach']){ echo(" checked");}?> value='on'>kurszach:<br><input class=filter type=text name='filter[kurszach]' value='<?php echo($this->filter['kurszach']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[datarozhd_from]' <?php if($this->filter_check['datarozhd_from']){ echo(" checked");}?> value='on'>datarozhd_from:<br><input class=filter type=text id='filter_datarozhd_from_fd' name='filter[datarozhd_from]' value='<?php echo($this->filter['datarozhd_from']);?>'><img src='images/b_calendar.png' onclick="openCalendar('', '', 'filter_datarozhd_from_fd', 'datetime', 'filter_datarozhd_from_fd');"><br><input type='checkbox' name='filter_check[datarozhd_to]' <?php if($this->filter_check['datarozhd_to']){ echo(" checked");}?> value='on'>datarozhd_to:<br><input class=filter type=text id='filter_datarozhd_to_fd' name='filter[datarozhd_to]' value='<?php echo($this->filter['datarozhd_to']);?>'><img src='images/b_calendar.png' onclick="openCalendar('', '', 'filter_datarozhd_to_fd', 'datetime', 'filter_datarozhd_to_fd');"></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=UchashchiesyaView&action=addUchashchiesyaAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>family</td>
<td>name</td>
<td>otch</td>
<td>gruppa</td>
<td>kurszach</td>
<td>datarozhd</td>
<td>mesto</td>
<td>adres</td>
<td>nation</td>
<td>zachprikaz</td>
<td>zachdata</td>
<td>obrazovanie</td>
<td>perevod2prikaz</td>
<td>perevod2data</td>
<td>perevod3prikaz</td>
<td>perevod3data</td>
<td>perevod4prikaz</td>
<td>perevod4data</td>
<td>perevod5prikaz</td>
<td>perevod5data</td>
<td>vypuskprikaz</td>
<td>vypuskdata</td>
<td>father</td>
<td>mother</td>
<td>parents</td>
<td>status</td>
<td>phone</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listuchenik as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['family']);?></td>
	<td><?php echo($onerec['name']);?></td>
	<td><?php echo($onerec['otch']);?></td>
	<td><?php echo($this->lookUp($this->listgruppa, $onerec['gruppa'], 'gruppa'));?></td>
	<td><?php echo($onerec['kurszach']);?></td>
	<td><?php echo($onerec['datarozhd']);?></td>
	<td><?php echo($onerec['mesto']);?></td>
	<td><?php echo($onerec['adres']);?></td>
	<td><?php echo($onerec['nation']);?></td>
	<td><?php echo($onerec['zachprikaz']);?></td>
	<td><?php echo($onerec['zachdata']);?></td>
	<td><?php echo($onerec['obrazovanie']);?></td>
	<td><?php echo($onerec['perevod2prikaz']);?></td>
	<td><?php echo($onerec['perevod2data']);?></td>
	<td><?php echo($onerec['perevod3prikaz']);?></td>
	<td><?php echo($onerec['perevod3data']);?></td>
	<td><?php echo($onerec['perevod4prikaz']);?></td>
	<td><?php echo($onerec['perevod4data']);?></td>
	<td><?php echo($onerec['perevod5prikaz']);?></td>
	<td><?php echo($onerec['perevod5data']);?></td>
	<td><?php echo($onerec['vypuskprikaz']);?></td>
	<td><?php echo($onerec['vypuskdata']);?></td>
	<td><?php echo($onerec['father']);?></td>
	<td><?php echo($onerec['mother']);?></td>
	<td><?php echo($onerec['parents']);?></td>
	<td><?php if($onerec['status']!=0){?>ON<?php }else{?>OFF<?php }?></td>
	<td><?php echo($onerec['phone']);?></td>
	<td><a href='?view=UchashchiesyaEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=UchashchiesyaView&action=delUchashchiesyaAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=UchashchiesyaView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>