<?php
class addUchashchiesyaAction{
	function Go(){
		$dbuchenik=new dbuchenik();
if($_SESSION['Uchashchiesya']['filter_check']['family']=='on'){
	$family=$_SESSION['Uchashchiesya']['filter']['family'];
}else{
	$family='';
}
if($_SESSION['Uchashchiesya']['filter_check']['name']=='on'){
	$name=$_SESSION['Uchashchiesya']['filter']['name'];
}else{
	$name='';
}
if($_SESSION['Uchashchiesya']['filter_check']['otch']=='on'){
	$otch=$_SESSION['Uchashchiesya']['filter']['otch'];
}else{
	$otch='';
}
if($_SESSION['Uchashchiesya']['filter_check']['gruppa']=='on'){
	$gruppa=$_SESSION['Uchashchiesya']['filter']['gruppa'];
}else{
	$gruppa=0;
}
if($_SESSION['Uchashchiesya']['filter_check']['kurszach']=='on'){
	$kurszach=$_SESSION['Uchashchiesya']['filter']['kurszach'];
}else{
	$kurszach=0;
}
if($_SESSION['Uchashchiesya']['filter_check']['datarozhd']=='on'){
	$datarozhd=$_SESSION['Uchashchiesya']['filter']['datarozhd'];
}else{
	$datarozhd=0;
}
if($_SESSION['Uchashchiesya']['filter_check']['mesto']=='on'){
	$mesto=$_SESSION['Uchashchiesya']['filter']['mesto'];
}else{
	$mesto='';
}
if($_SESSION['Uchashchiesya']['filter_check']['adres']=='on'){
	$adres=$_SESSION['Uchashchiesya']['filter']['adres'];
}else{
	$adres='';
}
if($_SESSION['Uchashchiesya']['filter_check']['nation']=='on'){
	$nation=$_SESSION['Uchashchiesya']['filter']['nation'];
}else{
	$nation='';
}
if($_SESSION['Uchashchiesya']['filter_check']['zachprikaz']=='on'){
	$zachprikaz=$_SESSION['Uchashchiesya']['filter']['zachprikaz'];
}else{
	$zachprikaz='';
}
if($_SESSION['Uchashchiesya']['filter_check']['zachdata']=='on'){
	$zachdata=$_SESSION['Uchashchiesya']['filter']['zachdata'];
}else{
	$zachdata=0;
}
if($_SESSION['Uchashchiesya']['filter_check']['obrazovanie']=='on'){
	$obrazovanie=$_SESSION['Uchashchiesya']['filter']['obrazovanie'];
}else{
	$obrazovanie='';
}
if($_SESSION['Uchashchiesya']['filter_check']['perevod2prikaz']=='on'){
	$perevod2prikaz=$_SESSION['Uchashchiesya']['filter']['perevod2prikaz'];
}else{
	$perevod2prikaz='';
}
if($_SESSION['Uchashchiesya']['filter_check']['perevod2data']=='on'){
	$perevod2data=$_SESSION['Uchashchiesya']['filter']['perevod2data'];
}else{
	$perevod2data=0;
}
if($_SESSION['Uchashchiesya']['filter_check']['perevod3prikaz']=='on'){
	$perevod3prikaz=$_SESSION['Uchashchiesya']['filter']['perevod3prikaz'];
}else{
	$perevod3prikaz='';
}
if($_SESSION['Uchashchiesya']['filter_check']['perevod3data']=='on'){
	$perevod3data=$_SESSION['Uchashchiesya']['filter']['perevod3data'];
}else{
	$perevod3data=0;
}
if($_SESSION['Uchashchiesya']['filter_check']['perevod4prikaz']=='on'){
	$perevod4prikaz=$_SESSION['Uchashchiesya']['filter']['perevod4prikaz'];
}else{
	$perevod4prikaz='';
}
if($_SESSION['Uchashchiesya']['filter_check']['perevod4data']=='on'){
	$perevod4data=$_SESSION['Uchashchiesya']['filter']['perevod4data'];
}else{
	$perevod4data=0;
}
if($_SESSION['Uchashchiesya']['filter_check']['perevod5prikaz']=='on'){
	$perevod5prikaz=$_SESSION['Uchashchiesya']['filter']['perevod5prikaz'];
}else{
	$perevod5prikaz='';
}
if($_SESSION['Uchashchiesya']['filter_check']['perevod5data']=='on'){
	$perevod5data=$_SESSION['Uchashchiesya']['filter']['perevod5data'];
}else{
	$perevod5data=0;
}
if($_SESSION['Uchashchiesya']['filter_check']['vypuskprikaz']=='on'){
	$vypuskprikaz=$_SESSION['Uchashchiesya']['filter']['vypuskprikaz'];
}else{
	$vypuskprikaz='';
}
if($_SESSION['Uchashchiesya']['filter_check']['vypuskdata']=='on'){
	$vypuskdata=$_SESSION['Uchashchiesya']['filter']['vypuskdata'];
}else{
	$vypuskdata=0;
}
if($_SESSION['Uchashchiesya']['filter_check']['father']=='on'){
	$father=$_SESSION['Uchashchiesya']['filter']['father'];
}else{
	$father='';
}
if($_SESSION['Uchashchiesya']['filter_check']['mother']=='on'){
	$mother=$_SESSION['Uchashchiesya']['filter']['mother'];
}else{
	$mother='';
}
if($_SESSION['Uchashchiesya']['filter_check']['parents']=='on'){
	$parents=$_SESSION['Uchashchiesya']['filter']['parents'];
}else{
	$parents='';
}
if($_SESSION['Uchashchiesya']['filter_check']['status']=='on'){
	$status=$_SESSION['Uchashchiesya']['filter']['status'];
}else{
	$status=0;
}
if($_SESSION['Uchashchiesya']['filter_check']['phone']=='on'){
	$phone=$_SESSION['Uchashchiesya']['filter']['phone'];
}else{
	$phone='';
}
$dbuchenik->add( $family,  $name,  $otch,  $gruppa,  $kurszach,  $datarozhd,  $mesto,  $adres,  $nation,  $zachprikaz,  $zachdata,  $obrazovanie,  $perevod2prikaz,  $perevod2data,  $perevod3prikaz,  $perevod3data,  $perevod4prikaz,  $perevod4data,  $perevod5prikaz,  $perevod5data,  $vypuskprikaz,  $vypuskdata,  $father,  $mother,  $parents,  $status,  $phone);
	}
}
?>