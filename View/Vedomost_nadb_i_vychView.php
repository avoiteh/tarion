<?php
class Vedomost_nadb_i_vychView{
	var $dbvednadbvych;
	var $listvednadbvych;
var $dbfront_user;
var $listfront_user;
var $dbnadbvych;
var $listnadbvych;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function Vedomost_nadb_i_vychView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Vedomost_nadb_i_vych'])){
			$_SESSION['Vedomost_nadb_i_vych']['filter']=array();
			$_SESSION['Vedomost_nadb_i_vych']['filter_check']=array();
			$_SESSION['Vedomost_nadb_i_vych']['page']=1;
			$_SESSION['Vedomost_nadb_i_vych']['limit']=100;
			$_SESSION['Vedomost_nadb_i_vych']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Vedomost_nadb_i_vych']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Vedomost_nadb_i_vych']['datafields']=array();
$_SESSION['Vedomost_nadb_i_vych']['datafields']['prepod']='int';
$_SESSION['Vedomost_nadb_i_vych']['filter']['prepod'] = mysql_escape_string($_REQUEST['filter']['prepod']);
$_SESSION['Vedomost_nadb_i_vych']['filter_check']['prepod'] = $_REQUEST['filter_check']['prepod'] == 'on';
$_SESSION['Vedomost_nadb_i_vych']['datafields']['tip']='int';
$_SESSION['Vedomost_nadb_i_vych']['filter']['tip'] = mysql_escape_string($_REQUEST['filter']['tip']);
$_SESSION['Vedomost_nadb_i_vych']['filter_check']['tip'] = $_REQUEST['filter_check']['tip'] == 'on';
$_SESSION['Vedomost_nadb_i_vych']['datafields']['god']='string';
$_SESSION['Vedomost_nadb_i_vych']['filter']['god'] = mysql_escape_string($_REQUEST['filter']['god']);
$_SESSION['Vedomost_nadb_i_vych']['filter_check']['god'] = $_REQUEST['filter_check']['god'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Vedomost_nadb_i_vych']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Vedomost_nadb_i_vych']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Vedomost_nadb_i_vych']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Vedomost_nadb_i_vych']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Vedomost_nadb_i_vych']['filter'];
		$this->filter_check=$_SESSION['Vedomost_nadb_i_vych']['filter_check'];
		$this->start=$_SESSION['Vedomost_nadb_i_vych']['page'];
		$this->limit=$_SESSION['Vedomost_nadb_i_vych']['limit'];
		$this->order=$_SESSION['Vedomost_nadb_i_vych']['order'];
		//создаём объекты доступа к таблицам
		$this->dbvednadbvych=new dbvednadbvych();
$this->dbfront_user = new dbfront_user();
//получаем лист для lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);$this->dbnadbvych = new dbnadbvych();
//получаем лист для lookUp
		$this->listnadbvych=$this->dbnadbvych->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Vedomost_nadb_i_vych']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Vedomost_nadb_i_vych']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Vedomost_nadb_i_vych']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbvednadbvych->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listvednadbvych=$this->dbvednadbvych->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?>
<form action='?view=Vedomost_nadb_i_vychView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[prepod]' <?php if($this->filter_check['prepod']){ echo(" checked");}?> value='on'>prepod:<br><?php echo($this->lookUpList($this->listfront_user, $this->filter['prepod'], 'family', 'filter[prepod]'));?></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[tip]' <?php if($this->filter_check['tip']){ echo(" checked");}?> value='on'>tip:<br><?php echo($this->lookUpList($this->listnadbvych, $this->filter['tip'], 'naim', 'filter[tip]'));?></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[god]' <?php if($this->filter_check['god']){ echo(" checked");}?> value='on'>god:<br><input class=filter type=text name='filter[god]' value='<?php echo($this->filter['god']);?>'></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=Vedomost_nadb_i_vychView&action=addVedomost_nadb_i_vychAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>prepod</td>
<td>tip</td>
<td>god</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listvednadbvych as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($this->lookUp($this->listfront_user, $onerec['prepod'], 'family'));?></td>
	<td><?php echo($this->lookUp($this->listnadbvych, $onerec['tip'], 'naim'));?></td>
	<td><?php echo($onerec['god']);?></td>
	<td><a href='?view=Vedomost_nadb_i_vychEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=Vedomost_nadb_i_vychView&action=delVedomost_nadb_i_vychAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=Vedomost_nadb_i_vychView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>