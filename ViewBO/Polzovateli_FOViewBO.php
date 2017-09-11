<?php
class Polzovateli_FOViewBO{
	var $dbfront_user;
	var $listfront_user;
var $dbfront_right;
var $listfront_right;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function Polzovateli_FOViewBO(){
		//инициализация конфигурации
		if(!isset($_SESSION['Polzovateli_FO'])){
			$_SESSION['Polzovateli_FO']['filter']=array();
			$_SESSION['Polzovateli_FO']['filter_check']=array();
			$_SESSION['Polzovateli_FO']['page']=1;
			$_SESSION['Polzovateli_FO']['limit']=100;
			$_SESSION['Polzovateli_FO']['order']='';
		}
		//собираем входные данные
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Polzovateli_FO']['filter']=array();
			//собираем поля формы фильтра
			//костыль - временный массив, в который сложим имена модифицированных полей дат
			$datafields=array();
$_SESSION['Polzovateli_FO']['filter']['id'] = mysql_escape_string($_REQUEST['filter']['id']);//*
$_SESSION['Polzovateli_FO']['filter_check']['id'] = $_REQUEST['filter_check']['id'] == 'on';
$_SESSION['Polzovateli_FO']['datafields']['email']='string';
$_SESSION['Polzovateli_FO']['filter']['email'] = mysql_escape_string($_REQUEST['filter']['email']);
$_SESSION['Polzovateli_FO']['filter_check']['email'] = $_REQUEST['filter_check']['email'] == 'on';
$_SESSION['Polzovateli_FO']['datafields']['password']='string';
$_SESSION['Polzovateli_FO']['filter']['password'] = mysql_escape_string($_REQUEST['filter']['password']);
$_SESSION['Polzovateli_FO']['filter_check']['password'] = $_REQUEST['filter_check']['password'] == 'on';
$_SESSION['Polzovateli_FO']['datafields']['right']='int';
$_SESSION['Polzovateli_FO']['filter']['right'] = mysql_escape_string($_REQUEST['filter']['right']);
$_SESSION['Polzovateli_FO']['filter_check']['right'] = $_REQUEST['filter_check']['right'] == 'on';

		}
		if(isset($_REQUEST['start'])){$_SESSION['Polzovateli_FO']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Polzovateli_FO']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Polzovateli_FO']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Polzovateli_FO']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Polzovateli_FO']['filter'];
		$this->filter_check=$_SESSION['Polzovateli_FO']['filter_check'];
		$this->start=$_SESSION['Polzovateli_FO']['page'];
		$this->limit=$_SESSION['Polzovateli_FO']['limit'];
		$this->order=$_SESSION['Polzovateli_FO']['order'];
		//создаём объекты доступа к таблицам
		$this->dbfront_user=new dbfront_user();
$this->dbfront_right = new dbfront_right();
//получаем лист для lookUp
		$this->listfront_right=$this->dbfront_right->load('','',0,0);
		
		//создать из $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Polzovateli_FO']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Polzovateli_FO']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Polzovateli_FO']['datafields'][$fid]=='string'){
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

<form action='?view=Polzovateli_FOViewBO' method=post>
<input type='submit' value='Фильтр'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[id]' <?php if($this->filter_check['id']){ echo(" checked");}?> value='on'>id:<br><input type=text name='filter[id]' value='<?php echo($this->filter['id']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[email]' <?php if($this->filter_check['email']){ echo(" checked");}?> value='on'>email:<br><input class=filter type=text name='filter[email]' value='<?php echo($this->filter['email']);?>'></td>
<td valign=top bgcolor='#eeeeee' nowrap><input type='checkbox' name='filter_check[password]' <?php if($this->filter_check['password']){ echo(" checked");}?> value='on'>password:<br><input class=filter type=text name='filter[password]' value='<?php echo($this->filter['password']);?>'></td>
<td valign=top bgcolor='#dddddd' nowrap><input type='checkbox' name='filter_check[right]' <?php if($this->filter_check['right']){ echo(" checked");}?> value='on'>right:<br><?php echo($this->lookUpList($this->listfront_right, $this->filter['right'], 'name', 'filter[right]'));?></td></tr></table>
</form>
<input type=button value=' Создать ' onclick='location.href="?view=Polzovateli_FOViewBO&action=addPolzovateli_FOActionBO"'><br>
Страница: <?php $this->shkala();?>
<table border="1">
<tr bgcolor='#cccccc'>
<td>ID</td>
<td>email</td>
<td>password</td>
<td>right</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listfront_user as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['id']);?></td>
	<td><?php echo($onerec['email']);?></td>
	<td><?php echo($onerec['password']);?></td>
	<td><?php echo($this->lookUp($this->listfront_right, $onerec['right'], 'name'));?></td>
	<td><a href='?view=Polzovateli_FOEditBO&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=Polzovateli_FOViewBO&action=delPolzovateli_FOActionBO&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=Polzovateli_FOViewBO&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>