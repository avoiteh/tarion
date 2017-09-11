<?php
class Sostav_komissiiView{
	var $dbsostav_komis;
	var $listsostav_komis;
var $dbkomiss;
var $listkomiss;
var $dbfront_user;
var $listfront_user;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function Sostav_komissiiView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Sostav_komissii'])){
			$_SESSION['Sostav_komissii']['filter']=array();
			$_SESSION['Sostav_komissii']['filter_check']=array();
			$_SESSION['Sostav_komissii']['page']=1;
			$_SESSION['Sostav_komissii']['limit']=100;
			$_SESSION['Sostav_komissii']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Sostav_komissii']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Sostav_komissii']['datafields']=array();
$_SESSION['Sostav_komissii']['datafields']['komis']='int';
$_SESSION['Sostav_komissii']['filter']['komis'] = mysql_escape_string($_REQUEST['filter']['komis']);
$_SESSION['Sostav_komissii']['filter_check']['komis'] = $_REQUEST['filter_check']['komis'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Sostav_komissii']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Sostav_komissii']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Sostav_komissii']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Sostav_komissii']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Sostav_komissii']['filter'];
		$this->filter_check=$_SESSION['Sostav_komissii']['filter_check'];
		$this->start=$_SESSION['Sostav_komissii']['page'];
		$this->limit=$_SESSION['Sostav_komissii']['limit'];
		$this->order=$_SESSION['Sostav_komissii']['order'];
		//создаём объекты доступа к таблицам
		$this->dbsostav_komis=new dbsostav_komis();
$this->dbkomiss = new dbkomiss();
//получаем лист для lookUp
		$this->listkomiss=$this->dbkomiss->load('','',0,0);$this->dbfront_user = new dbfront_user();
//получаем лист для lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Sostav_komissii']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Sostav_komissii']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Sostav_komissii']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbsostav_komis->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listsostav_komis=$this->dbsostav_komis->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?><a href='?view=Spisok_komissiyView'>&lt;&lt;&lt;&lt; Назад</br>
<form action='?view=Sostav_komissiiView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[komis]' <?php if($this->filter_check['komis']){ echo(" checked");}?> value='on'>komis:<br><?php echo($this->lookUpList($this->listkomiss, $this->filter['komis'], 'komiss', 'filter[komis]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=Sostav_komissiiView&action=addSostav_komissiiAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>komis</td>
<td>prepod</td>
<td>status</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listsostav_komis as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($this->lookUp($this->listkomiss, $onerec['komis'], 'komiss'));?></td>
	<td><?php echo($this->lookUp($this->listfront_user, $onerec['prepod'], 'family'));?></td>
	<td><?php if($onerec['status']!=0){?>ON<?php }else{?>OFF<?php }?></td>
	<td><a href='?view=Sostav_komissiiEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=Sostav_komissiiView&action=delSostav_komissiiAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=Sostav_komissiiView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>