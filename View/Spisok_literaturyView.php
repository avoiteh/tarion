<?php
class Spisok_literaturyView{
	var $dbbiblio;
	var $listbiblio;
var $dbbook_type;
var $listbook_type;
var $dbgrif;
var $listgrif;
var $dblibcat;
var $listlibcat;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function Spisok_literaturyView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Spisok_literatury'])){
			$_SESSION['Spisok_literatury']['filter']=array();
			$_SESSION['Spisok_literatury']['filter_check']=array();
			$_SESSION['Spisok_literatury']['page']=1;
			$_SESSION['Spisok_literatury']['limit']=100;
			$_SESSION['Spisok_literatury']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Spisok_literatury']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Spisok_literatury']['datafields']=array();
$_SESSION['Spisok_literatury']['filter']['id'] = mysql_escape_string($_REQUEST['filter']['id']);//*
$_SESSION['Spisok_literatury']['filter_check']['id'] = $_REQUEST['filter_check']['id'] == 'on';
$_SESSION['Spisok_literatury']['datafields']['booktype']='int';
$_SESSION['Spisok_literatury']['filter']['booktype'] = mysql_escape_string($_REQUEST['filter']['booktype']);
$_SESSION['Spisok_literatury']['filter_check']['booktype'] = $_REQUEST['filter_check']['booktype'] == 'on';
$_SESSION['Spisok_literatury']['datafields']['author']='string';
$_SESSION['Spisok_literatury']['filter']['author'] = mysql_escape_string($_REQUEST['filter']['author']);
$_SESSION['Spisok_literatury']['filter_check']['author'] = $_REQUEST['filter_check']['author'] == 'on';
$_SESSION['Spisok_literatury']['datafields']['title']='string';
$_SESSION['Spisok_literatury']['filter']['title'] = mysql_escape_string($_REQUEST['filter']['title']);
$_SESSION['Spisok_literatury']['filter_check']['title'] = $_REQUEST['filter_check']['title'] == 'on';
$_SESSION['Spisok_literatury']['filter']['dataizd_from'] = mysql_escape_string($_REQUEST['filter']['dataizd_from']);
$_SESSION['Spisok_literatury']['filter_check']['dataizd_from'] = $_REQUEST['filter_check']['dataizd_from'] == 'on';
$_SESSION['Spisok_literatury']['datafields']['dataizd_from']='from';
$_SESSION['Spisok_literatury']['filter']['dataizd_to'] = mysql_escape_string($_REQUEST['filter']['dataizd_to']);
$_SESSION['Spisok_literatury']['filter_check']['dataizd_to'] = $_REQUEST['filter_check']['dataizd_to'] == 'on';
$_SESSION['Spisok_literatury']['datafields']['dataizd_to']='to';
$_SESSION['Spisok_literatury']['datafields']['izdatel']='string';
$_SESSION['Spisok_literatury']['filter']['izdatel'] = mysql_escape_string($_REQUEST['filter']['izdatel']);
$_SESSION['Spisok_literatury']['filter_check']['izdatel'] = $_REQUEST['filter_check']['izdatel'] == 'on';
$_SESSION['Spisok_literatury']['datafields']['grif']='int';
$_SESSION['Spisok_literatury']['filter']['grif'] = mysql_escape_string($_REQUEST['filter']['grif']);
$_SESSION['Spisok_literatury']['filter_check']['grif'] = $_REQUEST['filter_check']['grif'] == 'on';
$_SESSION['Spisok_literatury']['datafields']['kolvo']='int';
$_SESSION['Spisok_literatury']['filter']['kolvo'] = mysql_escape_string($_REQUEST['filter']['kolvo']);
$_SESSION['Spisok_literatury']['filter_check']['kolvo'] = $_REQUEST['filter_check']['kolvo'] == 'on';
$_SESSION['Spisok_literatury']['datafields']['libcat']='int';
$_SESSION['Spisok_literatury']['filter']['libcat'] = mysql_escape_string($_REQUEST['filter']['libcat']);
$_SESSION['Spisok_literatury']['filter_check']['libcat'] = $_REQUEST['filter_check']['libcat'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Spisok_literatury']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Spisok_literatury']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Spisok_literatury']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Spisok_literatury']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Spisok_literatury']['filter'];
		$this->filter_check=$_SESSION['Spisok_literatury']['filter_check'];
		$this->start=$_SESSION['Spisok_literatury']['page'];
		$this->limit=$_SESSION['Spisok_literatury']['limit'];
		$this->order=$_SESSION['Spisok_literatury']['order'];
		//создаём объекты доступа к таблицам
		$this->dbbiblio=new dbbiblio();
$this->dbbook_type = new dbbook_type();
//получаем лист для lookUp
		$this->listbook_type=$this->dbbook_type->load('','',0,0);$this->dbgrif = new dbgrif();
//получаем лист для lookUp
		$this->listgrif=$this->dbgrif->load('','',0,0);$this->dblibcat = new dblibcat();
//получаем лист для lookUp
		$this->listlibcat=$this->dblibcat->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Spisok_literatury']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Spisok_literatury']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Spisok_literatury']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbbiblio->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listbiblio=$this->dbbiblio->load($this->where, $this->order, $start, $this->limit);
		//есть потомок
$this->childView='Predmetnaya_privyazka';

	}
	
	function Paint(){
		?>
<form action='?view=Spisok_literaturyView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[id]' <?php if($this->filter_check['id']){ echo(" checked");}?> value='on'>id:<br><input class=filter type=text name='filter[id]' value='<?php echo($this->filter['id']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[booktype]' <?php if($this->filter_check['booktype']){ echo(" checked");}?> value='on'>booktype:<br><?php echo($this->lookUpList($this->listbook_type, $this->filter['booktype'], 'booktype', 'filter[booktype]'));?></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[author]' <?php if($this->filter_check['author']){ echo(" checked");}?> value='on'>author:<br><input class=filter type=text name='filter[author]' value='<?php echo($this->filter['author']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[title]' <?php if($this->filter_check['title']){ echo(" checked");}?> value='on'>title:<br><input class=filter type=text name='filter[title]' value='<?php echo($this->filter['title']);?>'></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[dataizd_from]' <?php if($this->filter_check['dataizd_from']){ echo(" checked");}?> value='on'>dataizd_from:<br><input class=filter type=text id='filter_dataizd_from_fd' name='filter[dataizd_from]' value='<?php echo($this->filter['dataizd_from']);?>'><img src='images/b_calendar.png' onclick="openCalendar('', '', 'filter_dataizd_from_fd', 'datetime', 'filter_dataizd_from_fd');"><br><input type='checkbox' name='filter_check[dataizd_to]' <?php if($this->filter_check['dataizd_to']){ echo(" checked");}?> value='on'>dataizd_to:<br><input class=filter type=text id='filter_dataizd_to_fd' name='filter[dataizd_to]' value='<?php echo($this->filter['dataizd_to']);?>'><img src='images/b_calendar.png' onclick="openCalendar('', '', 'filter_dataizd_to_fd', 'datetime', 'filter_dataizd_to_fd');"></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[izdatel]' <?php if($this->filter_check['izdatel']){ echo(" checked");}?> value='on'>izdatel:<br><input class=filter type=text name='filter[izdatel]' value='<?php echo($this->filter['izdatel']);?>'></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[grif]' <?php if($this->filter_check['grif']){ echo(" checked");}?> value='on'>grif:<br><?php echo($this->lookUpList($this->listgrif, $this->filter['grif'], 'grif', 'filter[grif]'));?></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[kolvo]' <?php if($this->filter_check['kolvo']){ echo(" checked");}?> value='on'>kolvo:<br><input class=filter type=text name='filter[kolvo]' value='<?php echo($this->filter['kolvo']);?>'></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[libcat]' <?php if($this->filter_check['libcat']){ echo(" checked");}?> value='on'>libcat:<br><?php echo($this->lookUpList($this->listlibcat, $this->filter['libcat'], 'libcat', 'filter[libcat]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=Spisok_literaturyView&action=addSpisok_literaturyAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>ID</td>
<td>booktype</td>
<td>author</td>
<td>title</td>
<td>dataizd</td>
<td>izdatel</td>
<td>grif</td>
<td>kolvo</td>
<td>libcat</td>
<td></td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listbiblio as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['id']);?></td>
	<td><?php echo($this->lookUp($this->listbook_type, $onerec['booktype'], 'booktype'));?></td>
	<td><?php echo($onerec['author']);?></td>
	<td><?php echo($onerec['title']);?></td>
	<td><?php echo($onerec['dataizd']);?></td>
	<td><?php echo($onerec['izdatel']);?></td>
	<td><?php echo($this->lookUp($this->listgrif, $onerec['grif'], 'grif'));?></td>
	<td><?php echo($onerec['kolvo']);?></td>
	<td><?php echo($this->lookUp($this->listlibcat, $onerec['libcat'], 'libcat'));?></td>
	<td><a href='?view=Spisok_literaturyEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=Spisok_literaturyView&action=delSpisok_literaturyAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
<td><a href='?view=Predmetnaya_privyazkaView&filter_check[biblio]=on&filter[biblio]=<?=$onerec['id']?>'>Next</a></td>
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
				?><a href='?view=Spisok_literaturyView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>