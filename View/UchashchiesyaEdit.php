<?php
class UchashchiesyaEdit{
	var $id;
	var $dbuchenik;
	var $uchenik;
var $dbgruppa;
var $listgruppa;
function UchashchiesyaEdit(){
		$this->id=$_REQUEST['id']*1;
		$this->dbuchenik = new dbuchenik();
		$this->uchenik = $this->dbuchenik->get($this->id);
		
$this->dbgruppa = new dbgruppa();
//получаем лист для lookUp
		$this->listgruppa=$this->dbgruppa->load('','',0,0);
	}
	function Paint(){
		?>
		<a href='?view=UchashchiesyaView'>К списку</a>
		<table border="1">
		<form method="POST" enctype="multipart/form-data" action="?view=UchashchiesyaEdit&action=updateUchashchiesyaAction&id=<?=$this->id?>">

			<tr><td>family</td><td><input type="text" name="family" value="<?php echo(htmlspecialchars($this->uchenik['family']));?>"></td></tr>
			<tr><td>name</td><td><input type="text" name="name" value="<?php echo(htmlspecialchars($this->uchenik['name']));?>"></td></tr>
			<tr><td>otch</td><td><input type="text" name="otch" value="<?php echo(htmlspecialchars($this->uchenik['otch']));?>"></td></tr>
			<tr><td>gruppa</td><td><?php echo($this->lookUp($this->listgruppa, $this->uchenik['gruppa'], 'gruppa', 'gruppa'));?></td></tr>
			<tr><td>kurszach</td><td><input type="text" name="kurszach" value="<?php echo($this->uchenik['kurszach']);?>"></td></tr>
			<tr><td>datarozhd</td><td><input type="text" name="datarozhd" id="datarozhd_fd" value="<?php echo($this->uchenik['datarozhd']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'datarozhd_fd', 'datetime', 'datarozhd_fd');"></td></tr>
			<tr><td>mesto</td><td><input type="text" name="mesto" value="<?php echo(htmlspecialchars($this->uchenik['mesto']));?>"></td></tr>
			<tr><td>adres</td><td><input type="text" name="adres" value="<?php echo(htmlspecialchars($this->uchenik['adres']));?>"></td></tr>
			<tr><td>nation</td><td><input type="text" name="nation" value="<?php echo(htmlspecialchars($this->uchenik['nation']));?>"></td></tr>
			<tr><td>zachprikaz</td><td><input type="text" name="zachprikaz" value="<?php echo(htmlspecialchars($this->uchenik['zachprikaz']));?>"></td></tr>
			<tr><td>zachdata</td><td><input type="text" name="zachdata" id="zachdata_fd" value="<?php echo($this->uchenik['zachdata']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'zachdata_fd', 'datetime', 'zachdata_fd');"></td></tr>
			<tr><td>obrazovanie</td><td><input type="text" name="obrazovanie" value="<?php echo(htmlspecialchars($this->uchenik['obrazovanie']));?>"></td></tr>
			<tr><td>perevod2prikaz</td><td><input type="text" name="perevod2prikaz" value="<?php echo(htmlspecialchars($this->uchenik['perevod2prikaz']));?>"></td></tr>
			<tr><td>perevod2data</td><td><input type="text" name="perevod2data" id="perevod2data_fd" value="<?php echo($this->uchenik['perevod2data']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'perevod2data_fd', 'datetime', 'perevod2data_fd');"></td></tr>
			<tr><td>perevod3prikaz</td><td><input type="text" name="perevod3prikaz" value="<?php echo(htmlspecialchars($this->uchenik['perevod3prikaz']));?>"></td></tr>
			<tr><td>perevod3data</td><td><input type="text" name="perevod3data" id="perevod3data_fd" value="<?php echo($this->uchenik['perevod3data']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'perevod3data_fd', 'datetime', 'perevod3data_fd');"></td></tr>
			<tr><td>perevod4prikaz</td><td><input type="text" name="perevod4prikaz" value="<?php echo(htmlspecialchars($this->uchenik['perevod4prikaz']));?>"></td></tr>
			<tr><td>perevod4data</td><td><input type="text" name="perevod4data" id="perevod4data_fd" value="<?php echo($this->uchenik['perevod4data']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'perevod4data_fd', 'datetime', 'perevod4data_fd');"></td></tr>
			<tr><td>perevod5prikaz</td><td><input type="text" name="perevod5prikaz" value="<?php echo(htmlspecialchars($this->uchenik['perevod5prikaz']));?>"></td></tr>
			<tr><td>perevod5data</td><td><input type="text" name="perevod5data" id="perevod5data_fd" value="<?php echo($this->uchenik['perevod5data']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'perevod5data_fd', 'datetime', 'perevod5data_fd');"></td></tr>
			<tr><td>vypuskprikaz</td><td><input type="text" name="vypuskprikaz" value="<?php echo(htmlspecialchars($this->uchenik['vypuskprikaz']));?>"></td></tr>
			<tr><td>vypuskdata</td><td><input type="text" name="vypuskdata" id="vypuskdata_fd" value="<?php echo($this->uchenik['vypuskdata']);?>"><img src='images/b_calendar.png' onclick="openCalendar('', '', 'vypuskdata_fd', 'datetime', 'vypuskdata_fd');"></td></tr>
			<tr><td>father</td><td><input type="text" name="father" value="<?php echo(htmlspecialchars($this->uchenik['father']));?>"></td></tr>
			<tr><td>mother</td><td><input type="text" name="mother" value="<?php echo(htmlspecialchars($this->uchenik['mother']));?>"></td></tr>
			<tr><td>parents</td><td><input type="text" name="parents" value="<?php echo(htmlspecialchars($this->uchenik['parents']));?>"></td></tr>
			<tr><td>status</td><td><input type=checkbox name="status" value='1' <?php if($this->uchenik['status']!=0){ ?> checked<?php } ?>></td></tr>
			<tr><td>phone</td><td><input type="text" name="phone" value="<?php echo(htmlspecialchars($this->uchenik['phone']));?>"></td></tr>
		<tr><td colspan="2"><input value=" O.K. " type="submit"></td></tr>
		</form>
		</table>
		<?php
	}
	function lookUp(&$list, $id, $field_name, $name){
		$s="<select name='$name'>
		<option value=0> --- </option>
";
		$fna=explode(':',$field_name);
		if(is_array($list)){
			foreach ($list as $rec){
				$s.="<option value='$rec[id]'";
				if($rec['id']==$id){
					$s.=" selected";
				}
				$s.='>';
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
	function photo($photo, $name){
		$path=photoPath($photo).'/'.$name;
		if(file_exists($path)){
			return "<img src='$path'>";
		}else{
			return "<img src='./photo/noimage.png'>";
		}
	}
}
?>