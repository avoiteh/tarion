<?php
class Spisok_komissiyView{
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
	
	function Spisok_komissiyView(){
		//инициализация конфигурации
		if(!isset($_SESSION['Spisok_komissiy'])){
			$_SESSION['Spisok_komissiy']['filter']=array();
			$_SESSION['Spisok_komissiy']['filter_check']=array();
			$_SESSION['Spisok_komissiy']['page']=1;
			$_SESSION['Spisok_komissiy']['limit']=100;
			$_SESSION['Spisok_komissiy']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Spisok_komissiy']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			//в сессии его храним вместе с фильтром во избежание...
			$_SESSION['Spisok_komissiy']['datafields']=array();
$_SESSION['Spisok_komissiy']['datafields']['predsedat']='int';
$_SESSION['Spisok_komissiy']['filter']['predsedat'] = mysql_escape_string($_REQUEST['filter']['predsedat']);
$_SESSION['Spisok_komissiy']['filter_check']['predsedat'] = $_REQUEST['filter_check']['predsedat'] == 'on';
$_SESSION['Spisok_komissiy']['datafields']['status']='on_off';
$_SESSION['Spisok_komissiy']['filter']['status'] = mysql_escape_string($_REQUEST['filter']['status']);
$_SESSION['Spisok_komissiy']['filter_check']['status'] = $_REQUEST['filter_check']['status'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Spisok_komissiy']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Spisok_komissiy']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Spisok_komissiy']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Spisok_komissiy']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Spisok_komissiy']['filter'];
		$this->filter_check=$_SESSION['Spisok_komissiy']['filter_check'];
		$this->start=$_SESSION['Spisok_komissiy']['page'];
		$this->limit=$_SESSION['Spisok_komissiy']['limit'];
		$this->order=$_SESSION['Spisok_komissiy']['order'];
		//создаём объекты доступа к таблицам
		$this->dbkomiss=new dbkomiss();
$this->dbfront_user = new dbfront_user();
//получаем лист для lookUp
		$this->listfront_user=$this->dbfront_user->load('','',0,0);
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Spisok_komissiy']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Spisok_komissiy']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Spisok_komissiy']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbkomiss->count($this->where);
		
		//получаем основной лист
		$start=($this->page - 1) * $this->limit;
		$this->listkomiss=$this->dbkomiss->load($this->where, $this->order, $start, $this->limit);
		//есть потомок
$this->childView='Sostav_komissii';

	}
	
	function Paint(){
		?>
<form action='?view=Spisok_komissiyView' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[predsedat]' <?php if($this->filter_check['predsedat']){ echo(" checked");}?> value='on'>predsedat:<br><?php echo($this->lookUpList($this->listfront_user, $this->filter['predsedat'], 'family', 'filter[predsedat]'));?></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[status]' <?php if($this->filter_check['status']){ echo(" checked");}?> value='on'>status:<br><input type=checkbox name='filter[status]' value='on' <?php if($this->filter['status']!=0){?> checked<?php }?>'></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=Spisok_komissiyView&action=addSpisok_komissiyAction"'><br>
Страница: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>komiss</td>
<td>predsedat</td>
<td>status</td>
<td></td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listkomiss as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['komiss']);?></td>
	<td><?php echo($this->lookUp($this->listfront_user, $onerec['predsedat'], 'family'));?></td>
	<td><?php if($onerec['status']!=0){?>ON<?php }else{?>OFF<?php }?></td>
	<td><a href='?view=Spisok_komissiyEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=Spisok_komissiyView&action=delSpisok_komissiyAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
<td><a href='?view=Sostav_komissiiView&filter_check[komis]=on&filter[komis]=<?=$onerec['id']?>'>Next</a></td>
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
				?><a href='?view=Spisok_komissiyView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>