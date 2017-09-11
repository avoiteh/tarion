<?php
class Raspisanie_punktyView{
	var $dbraspisanie;
	var $listraspisanie;
var $dbpredmet;
var $listpredmet;
var $dbgruppa;
var $listgruppa;
var $dbfront_user;
var $listfront_user;
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
	
	function Raspisanie_punktyView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Raspisanie_punkty'])){
			$_SESSION['Raspisanie_punkty']['filter']=array();
			$_SESSION['Raspisanie_punkty']['filter_check']=array();
			$_SESSION['Raspisanie_punkty']['page']=1;
			$_SESSION['Raspisanie_punkty']['limit']=100;
			$_SESSION['Raspisanie_punkty']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Raspisanie_punkty']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Raspisanie_punkty']['datafields']=array();
$_SESSION['Raspisanie_punkty']['datafields']['week']='string';
$_SESSION['Raspisanie_punkty']['filter']['week'] = mysql_escape_string($_REQUEST['filter']['week']);
$_SESSION['Raspisanie_punkty']['filter_check']['week'] = $_REQUEST['filter_check']['week'] == 'on';
$_SESSION['Raspisanie_punkty']['datafields']['predmet']='int';
$_SESSION['Raspisanie_punkty']['filter']['predmet'] = mysql_escape_string($_REQUEST['filter']['predmet']);
$_SESSION['Raspisanie_punkty']['filter_check']['predmet'] = $_REQUEST['filter_check']['predmet'] == 'on';
$_SESSION['Raspisanie_punkty']['datafields']['gruppa']='int';
$_SESSION['Raspisanie_punkty']['filter']['gruppa'] = mysql_escape_string($_REQUEST['filter']['gruppa']);
$_SESSION['Raspisanie_punkty']['filter_check']['gruppa'] = $_REQUEST['filter_check']['gruppa'] == 'on';
$_SESSION['Raspisanie_punkty']['datafields']['prepod']='int';
$_SESSION['Raspisanie_punkty']['filter']['prepod'] = mysql_escape_string($_REQUEST['filter']['prepod']);
$_SESSION['Raspisanie_punkty']['filter_check']['prepod'] = $_REQUEST['filter_check']['prepod'] == 'on';
$_SESSION['Raspisanie_punkty']['datafields']['den']='int';
$_SESSION['Raspisanie_punkty']['filter']['den'] = mysql_escape_string($_REQUEST['filter']['den']);
$_SESSION['Raspisanie_punkty']['filter_check']['den'] = $_REQUEST['filter_check']['den'] == 'on';
$_SESSION['Raspisanie_punkty']['datafields']['para']='int';
$_SESSION['Raspisanie_punkty']['filter']['para'] = mysql_escape_string($_REQUEST['filter']['para']);
$_SESSION['Raspisanie_punkty']['filter_check']['para'] = $_REQUEST['filter_check']['para'] == 'on';
$_SESSION['Raspisanie_punkty']['datafields']['kabinet']='int';
$_SESSION['Raspisanie_punkty']['filter']['kabinet'] = mysql_escape_string($_REQUEST['filter']['kabinet']);
$_SESSION['Raspisanie_punkty']['filter_check']['kabinet'] = $_REQUEST['filter_check']['kabinet'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Raspisanie_punkty']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Raspisanie_punkty']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Raspisanie_punkty']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Raspisanie_punkty']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Raspisanie_punkty']['filter'];
		$this->filter_check=$_SESSION['Raspisanie_punkty']['filter_check'];
		$this->start=$_SESSION['Raspisanie_punkty']['page'];
		$this->limit=$_SESSION['Raspisanie_punkty']['limit'];
		$this->order=$_SESSION['Raspisanie_punkty']['order'];
		//создаём объекты доступа к таблицам
		$this->dbraspisanie=new dbraspisanie();
$this->dbpredmet = new dbpredmet();
//получаем лист для lookUp
		$this->listpredmet=$this->dbpredmet->load('','',0,0);$this->dbgruppa = new dbgruppa();
//получаем лист для lookUp
		$this->listgruppa=$this->dbgruppa->load('','',0,0);$this->dbfront_user = new dbfront_user();
//получаем лист для lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);$this->dbkabinet = new dbkabinet();
//получаем лист для lookUp
		$this->listkabinet=$this->dbkabinet->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Raspisanie_punkty']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Raspisanie_punkty']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Raspisanie_punkty']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbraspisanie->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listraspisanie=$this->dbraspisanie->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?>
<form action='?view=Raspisanie_punktyView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[week]' <?php if($this->filter_check['week']){ echo(" checked");}?> value='on'>week:<br><input class=filter type=text name='filter[week]' value='<?php echo($this->filter['week']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[predmet]' <?php if($this->filter_check['predmet']){ echo(" checked");}?> value='on'>predmet:<br><?php echo($this->lookUpList($this->listpredmet, $this->filter['predmet'], 'predmet', 'filter[predmet]'));?></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[gruppa]' <?php if($this->filter_check['gruppa']){ echo(" checked");}?> value='on'>gruppa:<br><?php echo($this->lookUpList($this->listgruppa, $this->filter['gruppa'], 'gruppa', 'filter[gruppa]'));?></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[prepod]' <?php if($this->filter_check['prepod']){ echo(" checked");}?> value='on'>prepod:<br><?php echo($this->lookUpList($this->listfront_user, $this->filter['prepod'], 'family', 'filter[prepod]'));?></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[den]' <?php if($this->filter_check['den']){ echo(" checked");}?> value='on'>den:<br><input class=filter type=text name='filter[den]' value='<?php echo($this->filter['den']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[para]' <?php if($this->filter_check['para']){ echo(" checked");}?> value='on'>para:<br><input class=filter type=text name='filter[para]' value='<?php echo($this->filter['para']);?>'></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[kabinet]' <?php if($this->filter_check['kabinet']){ echo(" checked");}?> value='on'>kabinet:<br><?php echo($this->lookUpList($this->listkabinet, $this->filter['kabinet'], 'kabinet', 'filter[kabinet]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=Raspisanie_punktyView&action=addRaspisanie_punktyAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>week</td>
<td>predmet</td>
<td>gruppa</td>
<td>prepod</td>
<td>den</td>
<td>para</td>
<td>kabinet</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listraspisanie as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['week']);?></td>
	<td><?php echo($this->lookUp($this->listpredmet, $onerec['predmet'], 'predmet'));?></td>
	<td><?php echo($this->lookUp($this->listgruppa, $onerec['gruppa'], 'gruppa'));?></td>
	<td><?php echo($this->lookUp($this->listfront_user, $onerec['prepod'], 'family'));?></td>
	<td><?php echo($onerec['den']);?></td>
	<td><?php echo($onerec['para']);?></td>
	<td><?php echo($this->lookUp($this->listkabinet, $onerec['kabinet'], 'kabinet'));?></td>
	<td><a href='?view=Raspisanie_punktyEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=Raspisanie_punktyView&action=delRaspisanie_punktyAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=Raspisanie_punktyView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>