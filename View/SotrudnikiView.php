<?php
class SotrudnikiView{
	var $dbfront_user;
	var $listfront_user;
var $dbfront_right;
var $listfront_right;
var $dbkabinet;
var $listkabinet;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function SotrudnikiView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Sotrudniki'])){
			$_SESSION['Sotrudniki']['filter']=array();
			$_SESSION['Sotrudniki']['filter_check']=array();
			$_SESSION['Sotrudniki']['page']=1;
			$_SESSION['Sotrudniki']['limit']=100;
			$_SESSION['Sotrudniki']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Sotrudniki']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Sotrudniki']['datafields']=array();
$_SESSION['Sotrudniki']['datafields']['email']='string';
$_SESSION['Sotrudniki']['filter']['email'] = mysql_escape_string($_REQUEST['filter']['email']);
$_SESSION['Sotrudniki']['filter_check']['email'] = $_REQUEST['filter_check']['email'] == 'on';
$_SESSION['Sotrudniki']['datafields']['family']='string';
$_SESSION['Sotrudniki']['filter']['family'] = mysql_escape_string($_REQUEST['filter']['family']);
$_SESSION['Sotrudniki']['filter_check']['family'] = $_REQUEST['filter_check']['family'] == 'on';
$_SESSION['Sotrudniki']['filter']['dataworkstart_from'] = mysql_escape_string($_REQUEST['filter']['dataworkstart_from']);
$_SESSION['Sotrudniki']['filter_check']['dataworkstart_from'] = $_REQUEST['filter_check']['dataworkstart_from'] == 'on';
$_SESSION['Sotrudniki']['datafields']['dataworkstart_from']='from';
$_SESSION['Sotrudniki']['filter']['dataworkstart_to'] = mysql_escape_string($_REQUEST['filter']['dataworkstart_to']);
$_SESSION['Sotrudniki']['filter_check']['dataworkstart_to'] = $_REQUEST['filter_check']['dataworkstart_to'] == 'on';
$_SESSION['Sotrudniki']['datafields']['dataworkstart_to']='to';
$_SESSION['Sotrudniki']['datafields']['razryd']='int';
$_SESSION['Sotrudniki']['filter']['razryd'] = mysql_escape_string($_REQUEST['filter']['razryd']);
$_SESSION['Sotrudniki']['filter_check']['razryd'] = $_REQUEST['filter_check']['razryd'] == 'on';
$_SESSION['Sotrudniki']['datafields']['category']='int';
$_SESSION['Sotrudniki']['filter']['category'] = mysql_escape_string($_REQUEST['filter']['category']);
$_SESSION['Sotrudniki']['filter_check']['category'] = $_REQUEST['filter_check']['category'] == 'on';
$_SESSION['Sotrudniki']['datafields']['kabinet']='int';
$_SESSION['Sotrudniki']['filter']['kabinet'] = mysql_escape_string($_REQUEST['filter']['kabinet']);
$_SESSION['Sotrudniki']['filter_check']['kabinet'] = $_REQUEST['filter_check']['kabinet'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Sotrudniki']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Sotrudniki']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Sotrudniki']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Sotrudniki']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Sotrudniki']['filter'];
		$this->filter_check=$_SESSION['Sotrudniki']['filter_check'];
		$this->start=$_SESSION['Sotrudniki']['page'];
		$this->limit=$_SESSION['Sotrudniki']['limit'];
		$this->order=$_SESSION['Sotrudniki']['order'];
		//создаём объекты доступа к таблицам
		$this->dbfront_user=new dbfront_user();
$this->dbfront_right = new dbfront_right();
//получаем лист для lookUp
		$this->listfront_right=$this->dbfront_right->load('','',0,0);$this->dbkabinet = new dbkabinet();
//получаем лист для lookUp
		$this->listkabinet=$this->dbkabinet->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Sotrudniki']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Sotrudniki']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Sotrudniki']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbfront_user->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listfront_user=$this->dbfront_user->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?>
<form action='?view=SotrudnikiView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[email]' <?php if($this->filter_check['email']){ echo(" checked");}?> value='on'>email:<br><input class=filter type=text name='filter[email]' value='<?php echo($this->filter['email']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[family]' <?php if($this->filter_check['family']){ echo(" checked");}?> value='on'>family:<br><input class=filter type=text name='filter[family]' value='<?php echo($this->filter['family']);?>'></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[dataworkstart_from]' <?php if($this->filter_check['dataworkstart_from']){ echo(" checked");}?> value='on'>dataworkstart_from:<br><input class=filter type=text id='filter_dataworkstart_from_fd' name='filter[dataworkstart_from]' value='<?php echo($this->filter['dataworkstart_from']);?>'><img src='images/b_calendar.png' onclick="openCalendar('', '', 'filter_dataworkstart_from_fd', 'datetime', 'filter_dataworkstart_from_fd');"><br><input type='checkbox' name='filter_check[dataworkstart_to]' <?php if($this->filter_check['dataworkstart_to']){ echo(" checked");}?> value='on'>dataworkstart_to:<br><input class=filter type=text id='filter_dataworkstart_to_fd' name='filter[dataworkstart_to]' value='<?php echo($this->filter['dataworkstart_to']);?>'><img src='images/b_calendar.png' onclick="openCalendar('', '', 'filter_dataworkstart_to_fd', 'datetime', 'filter_dataworkstart_to_fd');"></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[razryd]' <?php if($this->filter_check['razryd']){ echo(" checked");}?> value='on'>razryd:<br><input class=filter type=text name='filter[razryd]' value='<?php echo($this->filter['razryd']);?>'></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[category]' <?php if($this->filter_check['category']){ echo(" checked");}?> value='on'>category:<br><input class=filter type=text name='filter[category]' value='<?php echo($this->filter['category']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[kabinet]' <?php if($this->filter_check['kabinet']){ echo(" checked");}?> value='on'>kabinet:<br><?php echo($this->lookUpList($this->listkabinet, $this->filter['kabinet'], 'kabinet', 'filter[kabinet]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=SotrudnikiView&action=addSotrudnikiAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>email</td>
<td>password</td>
<td>right</td>
<td>login</td>
<td>family</td>
<td>name</td>
<td>otch</td>
<td>dataworkstart</td>
<td>razryd</td>
<td>category</td>
<td>kabinet</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listfront_user as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['email']);?></td>
	<td><?php echo($onerec['password']);?></td>
	<td><?php echo($this->lookUp($this->listfront_right, $onerec['right'], 'name'));?></td>
	<td><?php echo($onerec['login']);?></td>
	<td><?php echo($onerec['family']);?></td>
	<td><?php echo($onerec['name']);?></td>
	<td><?php echo($onerec['otch']);?></td>
	<td><?php echo($onerec['dataworkstart']);?></td>
	<td><?php echo($onerec['razryd']);?></td>
	<td><?php echo($onerec['category']);?></td>
	<td><?php echo($this->lookUp($this->listkabinet, $onerec['kabinet'], 'kabinet'));?></td>
	<td><a href='?view=SotrudnikiEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=SotrudnikiView&action=delSotrudnikiAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=SotrudnikiView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>