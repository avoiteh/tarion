<?php
class Tipy_izdaniyView{
	var $dbbook_type;
	var $listbook_type;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function Tipy_izdaniyView(){
		//������������� ������������
		if(!isset($_SESSION['Tipy_izdaniy'])){
			$_SESSION['Tipy_izdaniy']['filter']=array();
			$_SESSION['Tipy_izdaniy']['filter_check']=array();
			$_SESSION['Tipy_izdaniy']['page']=1;
			$_SESSION['Tipy_izdaniy']['limit']=100;
			$_SESSION['Tipy_izdaniy']['order']='';
		}
		//�������� ������� ������
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Tipy_izdaniy']['filter']=array();
			//�������� ���� ����� �������
			//������� - ��������� ������, � ������� ������ ����� ���������������� ����� ���
			//� ������ ��� ������ ������ � �������� �� ���������...
			$_SESSION['Tipy_izdaniy']['datafields']=array();

		}
		if(isset($_REQUEST['start'])){$_SESSION['Tipy_izdaniy']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Tipy_izdaniy']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Tipy_izdaniy']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Tipy_izdaniy']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Tipy_izdaniy']['filter'];
		$this->filter_check=$_SESSION['Tipy_izdaniy']['filter_check'];
		$this->start=$_SESSION['Tipy_izdaniy']['page'];
		$this->limit=$_SESSION['Tipy_izdaniy']['limit'];
		$this->order=$_SESSION['Tipy_izdaniy']['order'];
		//������ ������� ������� � ��������
		$this->dbbook_type=new dbbook_type();

		//������� �� $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Tipy_izdaniy']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Tipy_izdaniy']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Tipy_izdaniy']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbbook_type->count($this->where);
		
		//�������� �������� ����
		$start=($this->page - 1) * $this->limit;
		$this->listbook_type=$this->dbbook_type->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?>
<form action='?view=Tipy_izdaniyView' method=post>
<input type='submit' value='������'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr></tr></table>
</form>
<input type=button value=' ������� ' onclick='location.href="?view=Tipy_izdaniyView&action=addTipy_izdaniyAction"'><br>
��������: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>booktype</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listbook_type as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['booktype']);?></td>
	<td><a href='?view=Tipy_izdaniyEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=Tipy_izdaniyView&action=delTipy_izdaniyAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
</tr><?php
			if($col=='eeeeee'){$col='dddddd';}else{$col='eeeeee';}
		}
?>
</table>
��������: <?php
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
				?><a href='?view=Tipy_izdaniyView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>