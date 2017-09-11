<?php
class Metod_razrabotkiView{
	var $dbreg_book;
	var $listreg_book;
var $dbfront_user;
var $listfront_user;
var $dbprotokols;
var $listprotokols;
var $dbkomiss;
var $listkomiss;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function Metod_razrabotkiView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Metod_razrabotki'])){
			$_SESSION['Metod_razrabotki']['filter']=array();
			$_SESSION['Metod_razrabotki']['filter_check']=array();
			$_SESSION['Metod_razrabotki']['page']=1;
			$_SESSION['Metod_razrabotki']['limit']=100;
			$_SESSION['Metod_razrabotki']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Metod_razrabotki']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Metod_razrabotki']['datafields']=array();
$_SESSION['Metod_razrabotki']['datafields']['prepod']='int';
$_SESSION['Metod_razrabotki']['filter']['prepod'] = mysql_escape_string($_REQUEST['filter']['prepod']);
$_SESSION['Metod_razrabotki']['filter_check']['prepod'] = $_REQUEST['filter_check']['prepod'] == 'on';
$_SESSION['Metod_razrabotki']['datafields']['komprot']='int';
$_SESSION['Metod_razrabotki']['filter']['komprot'] = mysql_escape_string($_REQUEST['filter']['komprot']);
$_SESSION['Metod_razrabotki']['filter_check']['komprot'] = $_REQUEST['filter_check']['komprot'] == 'on';
$_SESSION['Metod_razrabotki']['datafields']['komis']='int';
$_SESSION['Metod_razrabotki']['filter']['komis'] = mysql_escape_string($_REQUEST['filter']['komis']);
$_SESSION['Metod_razrabotki']['filter_check']['komis'] = $_REQUEST['filter_check']['komis'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Metod_razrabotki']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Metod_razrabotki']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Metod_razrabotki']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Metod_razrabotki']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Metod_razrabotki']['filter'];
		$this->filter_check=$_SESSION['Metod_razrabotki']['filter_check'];
		$this->start=$_SESSION['Metod_razrabotki']['page'];
		$this->limit=$_SESSION['Metod_razrabotki']['limit'];
		$this->order=$_SESSION['Metod_razrabotki']['order'];
		//создаём объекты доступа к таблицам
		$this->dbreg_book=new dbreg_book();
$this->dbfront_user = new dbfront_user();
//получаем лист для lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);$this->dbprotokols = new dbprotokols();
//получаем лист для lookUp
		$this->listprotokols=$this->dbprotokols->load('','',0,0);$this->dbkomiss = new dbkomiss();
//получаем лист для lookUp
		$this->listkomiss=$this->dbkomiss->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Metod_razrabotki']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Metod_razrabotki']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Metod_razrabotki']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbreg_book->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listreg_book=$this->dbreg_book->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?>
<form action='?view=Metod_razrabotkiView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[prepod]' <?php if($this->filter_check['prepod']){ echo(" checked");}?> value='on'>prepod:<br><?php echo($this->lookUpList($this->listfront_user, $this->filter['prepod'], 'family', 'filter[prepod]'));?></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[komprot]' <?php if($this->filter_check['komprot']){ echo(" checked");}?> value='on'>komprot:<br><?php echo($this->lookUpList($this->listprotokols, $this->filter['komprot'], 'nomer', 'filter[komprot]'));?></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[komis]' <?php if($this->filter_check['komis']){ echo(" checked");}?> value='on'>komis:<br><?php echo($this->lookUpList($this->listkomiss, $this->filter['komis'], 'komiss', 'filter[komis]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=Metod_razrabotkiView&action=addMetod_razrabotkiAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>datareg</td>
<td>nomer</td>
<td>naim</td>
<td>prepod</td>
<td>komprot</td>
<td>komis</td>
<td>status</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listreg_book as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['datareg']);?></td>
	<td><?php echo($onerec['nomer']);?></td>
	<td><?php echo($onerec['naim']);?></td>
	<td><?php echo($this->lookUp($this->listfront_user, $onerec['prepod'], 'family'));?></td>
	<td><?php echo($this->lookUp($this->listprotokols, $onerec['komprot'], 'nomer'));?></td>
	<td><?php echo($this->lookUp($this->listkomiss, $onerec['komis'], 'komiss'));?></td>
	<td><?php if($onerec['status']!=0){?>ON<?php }else{?>OFF<?php }?></td>
	<td><a href='?view=Metod_razrabotkiEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=Metod_razrabotkiView&action=delMetod_razrabotkiAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=Metod_razrabotkiView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>