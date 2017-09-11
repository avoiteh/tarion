<?php
class SpetsialnostiView{
	var $dbtop_spec;
	var $listtop_spec;
var $filter;
	var $filter_check;
	var $where='';
	var $page=1;
	var $limit=0;
	var $order='';
	var $cnt;
	var $childView='';
	
	function SpetsialnostiView(){
		//������������� ������������
		if(!isset($_SESSION['Spetsialnosti'])){
			$_SESSION['Spetsialnosti']['filter']=array();
			$_SESSION['Spetsialnosti']['filter_check']=array();
			$_SESSION['Spetsialnosti']['page']=1;
			$_SESSION['Spetsialnosti']['limit']=100;
			$_SESSION['Spetsialnosti']['order']='';
		}
		//�������� ������� ������
		if(isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])){
			$_SESSION['Spetsialnosti']['filter']=array();
			//�������� ���� ����� �������
			//������� - ��������� ������, � ������� ������ ����� ���������������� ����� ���
			//� ������ ��� ������ ������ � �������� �� ���������...
			$_SESSION['Spetsialnosti']['datafields']=array();

		}
		if(isset($_REQUEST['start'])){$_SESSION['Spetsialnosti']['page']=$_REQUEST['page']*1;}
		if(isset($_REQUEST['limit'])){$_SESSION['Spetsialnosti']['limit']=$_REQUEST['limit']*1;}
		if(isset($_REQUEST['order'])){
			$_SESSION['Spetsialnosti']['order'] = mysql_escape_string($_REQUEST['order']);
		}
//		if(isset($_REQUEST['filter_id'])){
//			$_SESSION['Spetsialnosti']['filter']=array("id"=>$_REQUEST['filter_id']*1);
//		}
		
		$this->filter=$_SESSION['Spetsialnosti']['filter'];
		$this->filter_check=$_SESSION['Spetsialnosti']['filter_check'];
		$this->start=$_SESSION['Spetsialnosti']['page'];
		$this->limit=$_SESSION['Spetsialnosti']['limit'];
		$this->order=$_SESSION['Spetsialnosti']['order'];
		//������ ������� ������� � ��������
		$this->dbtop_spec=new dbtop_spec();

		//������� �� $filter => $where
		$this->where='';
		$d='';
		if(is_array($this->filter)){
			foreach ($this->filter as $fid => $fval){
				if($this->filter_check[$fid]){
					if($_SESSION['Spetsialnosti']['datafields'][$fid]=='from'){
						$p0=strpos($fid,'_from');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`>='$fval'";
					}else if($_SESSION['Spetsialnosti']['datafields'][$fid]=='to'){
						$p0=strpos($fid,'_to');
						$fid=substr($fid,0,$p0);
						$this->where.=$d."`$fid`<='$fval'";
					}else if($_SESSION['Spetsialnosti']['datafields'][$fid]=='string'){
						$this->where.=$d."`$fid` LIKE '$fval'";
					}else{
						$this->where.=$d."`$fid`='$fval'";
					}
					$d=' AND ';
				}
			}
		}
		$this->cnt = $this->dbtop_spec->count($this->where);
		
		//�������� �������� ����
		$start=($this->page - 1) * $this->limit;
		$this->listtop_spec=$this->dbtop_spec->load($this->where, $this->order, $start, $this->limit);
		
	}
	
	function Paint(){
		?>
<form action='?view=SpetsialnostiView' method=post>
<input type='submit' value='������'>
<table border=0 cellpadding=0 cellspacing=0 style='font-size:12px;'>
<tr></tr></table>
</form>
<input type=button value=' ������� ' onclick='location.href="?view=SpetsialnostiView&action=addSpetsialnostiAction"'><br>
��������: <?php $this->shkala(); ?>
<table border="0" cellspacing=0 cellpadding=0>
<tr bgcolor='#cccccc'>
<td>topspec</td>
<td></td>
<td></td>
</tr>
<?php
		$col='eeeeee';
		foreach ($this->listtop_spec as $i => $onerec){
			?><tr bgcolor='#<?=$col?>'>
	<td><?php echo($onerec['topspec']);?></td>
	<td><a href='?view=SpetsialnostiEdit&id=<?=$onerec['id']?>'><img src='images/b_edit.png'></a></td>
	<td><a href='?view=SpetsialnostiView&action=delSpetsialnostiAction&id=<?=$onerec['id']?>'><img src='images/b_drop.png'></a></td>
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
				?><a href='?view=SpetsialnostiView&page=<?php echo($i);?>'><?php echo ($i+1);?></a><?php
			}
		}
	}
}
?>