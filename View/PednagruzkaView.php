<?php
class PednagruzkaView{
	var $dbped_nagr;
	var $listped_nagr;
var $dbfront_user;
var $listfront_user;
var $dbpredmet;
var $listpredmet;
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
	
	function PednagruzkaView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Pednagruzka'])){
			$_SESSION['Pednagruzka']['filter']=array();
			$_SESSION['Pednagruzka']['filter_check']=array();
			$_SESSION['Pednagruzka']['page']=1;
			$_SESSION['Pednagruzka']['limit']=100;
			$_SESSION['Pednagruzka']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Pednagruzka']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Pednagruzka']['datafields']=array();
$_SESSION['Pednagruzka']['datafields']['god']='string';
$_SESSION['Pednagruzka']['filter']['god'] = mysql_escape_string($_REQUEST['filter']['god']);
$_SESSION['Pednagruzka']['filter_check']['god'] = $_REQUEST['filter_check']['god'] == 'on';
$_SESSION['Pednagruzka']['datafields']['prepod']='int';
$_SESSION['Pednagruzka']['filter']['prepod'] = mysql_escape_string($_REQUEST['filter']['prepod']);
$_SESSION['Pednagruzka']['filter_check']['prepod'] = $_REQUEST['filter_check']['prepod'] == 'on';
$_SESSION['Pednagruzka']['datafields']['predmet']='int';
$_SESSION['Pednagruzka']['filter']['predmet'] = mysql_escape_string($_REQUEST['filter']['predmet']);
$_SESSION['Pednagruzka']['filter_check']['predmet'] = $_REQUEST['filter_check']['predmet'] == 'on';
$_SESSION['Pednagruzka']['datafields']['gruppa']='int';
$_SESSION['Pednagruzka']['filter']['gruppa'] = mysql_escape_string($_REQUEST['filter']['gruppa']);
$_SESSION['Pednagruzka']['filter_check']['gruppa'] = $_REQUEST['filter_check']['gruppa'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Pednagruzka']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Pednagruzka']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Pednagruzka']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Pednagruzka']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Pednagruzka']['filter'];
		$this->filter_check=$_SESSION['Pednagruzka']['filter_check'];
		$this->start=$_SESSION['Pednagruzka']['page'];
		$this->limit=$_SESSION['Pednagruzka']['limit'];
		$this->order=$_SESSION['Pednagruzka']['order'];
		//создаём объекты доступа к таблицам
		$this->dbped_nagr=new dbped_nagr();
$this->dbfront_user = new dbfront_user();
//получаем лист для lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);$this->dbpredmet = new dbpredmet();
//получаем лист для lookUp
		$this->listpredmet=$this->dbpredmet->load('','',0,0);$this->dbgruppa = new dbgruppa();
//получаем лист для lookUp
		$this->listgruppa=$this->dbgruppa->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Pednagruzka']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Pednagruzka']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Pednagruzka']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbped_nagr->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listped_nagr=$this->dbped_nagr->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?>
<form action='?view=PednagruzkaView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[god]' <?php if($this->filter_check['god']){ echo(" checked");}?> value='on'>god:<br><input class=filter type=text name='filter[god]' value='<?php echo($this->filter['god']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[prepod]' <?php if($this->filter_check['prepod']){ echo(" checked");}?> value='on'>prepod:<br><?php echo($this->lookUpList($this->listfront_user, $this->filter['prepod'], 'family', 'filter[prepod]'));?></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[predmet]' <?php if($this->filter_check['predmet']){ echo(" checked");}?> value='on'>predmet:<br><?php echo($this->lookUpList($this->listpredmet, $this->filter['predmet'], 'predmet', 'filter[predmet]'));?></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[gruppa]' <?php if($this->filter_check['gruppa']){ echo(" checked");}?> value='on'>gruppa:<br><?php echo($this->lookUpList($this->listgruppa, $this->filter['gruppa'], 'gruppa', 'filter[gruppa]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=PednagruzkaView&action=addPednagruzkaAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>god</td>
<td>prepod</td>
<td>predmet</td>
<td>gruppa</td>
<td>theory</td>
<td>praktik</td>
<td>kurs</td>
<td>kurstest</td>
<td>examine</td>
<td>allhour</td>
<td>sem1chas</td>
<td>sem1ned</td>
<td>sem2chas</td>
<td>sem2ned</td>
<td>sem1vych</td>
<td>sem2vych</td>
<td>prikaz</td>
<td>remark</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listped_nagr as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['god']);?></td>
	<td><?php echo($this->lookUp($this->listfront_user, $onerec['prepod'], 'family'));?></td>
	<td><?php echo($this->lookUp($this->listpredmet, $onerec['predmet'], 'predmet'));?></td>
	<td><?php echo($this->lookUp($this->listgruppa, $onerec['gruppa'], 'gruppa'));?></td>
	<td><?php echo($onerec['theory']);?></td>
	<td><?php echo($onerec['praktik']);?></td>
	<td><?php echo($onerec['kurs']);?></td>
	<td><?php echo($onerec['kurstest']);?></td>
	<td><?php echo($onerec['examine']);?></td>
	<td><?php echo($onerec['allhour']);?></td>
	<td><?php echo($onerec['sem1chas']);?></td>
	<td><?php echo($onerec['sem1ned']);?></td>
	<td><?php echo($onerec['sem2chas']);?></td>
	<td><?php echo($onerec['sem2ned']);?></td>
	<td><?php echo($onerec['sem1vych']);?></td>
	<td><?php echo($onerec['sem2vych']);?></td>
	<td><?php echo($onerec['prikaz']);?></td>
	<td><?php echo($onerec['remark']);?></td>
	<td><a href='?view=PednagruzkaEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=PednagruzkaView&action=delPednagruzkaAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=PednagruzkaView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>