<?php
class addUchplan_soderzhanieAction{
	function Go(){
		$dbuch_cont=new dbuch_cont();
if($_SESSION['Uchplan_soderzhanie']['filter_check']['plann']=='on'){
	$plann=$_SESSION['Uchplan_soderzhanie']['filter']['plann'];
}else{
	$plann=0;
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['indexplan']=='on'){
	$indexplan=$_SESSION['Uchplan_soderzhanie']['filter']['indexplan'];
}else{
	$indexplan='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['predmet']=='on'){
	$predmet=$_SESSION['Uchplan_soderzhanie']['filter']['predmet'];
}else{
	$predmet=0;
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['theory']=='on'){
	$theory=$_SESSION['Uchplan_soderzhanie']['filter']['theory'];
}else{
	$theory=0;
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['praktik']=='on'){
	$praktik=$_SESSION['Uchplan_soderzhanie']['filter']['praktik'];
}else{
	$praktik=0;
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kursov']=='on'){
	$kursov=$_SESSION['Uchplan_soderzhanie']['filter']['kursov'];
}else{
	$kursov=0;
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['samost']=='on'){
	$samost=$_SESSION['Uchplan_soderzhanie']['filter']['samost'];
}else{
	$samost=0;
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kolvokontrol']=='on'){
	$kolvokontrol=$_SESSION['Uchplan_soderzhanie']['filter']['kolvokontrol'];
}else{
	$kolvokontrol=0;
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['chassem1']=='on'){
	$chassem1=$_SESSION['Uchplan_soderzhanie']['filter']['chassem1'];
}else{
	$chassem1='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['chassem2']=='on'){
	$chassem2=$_SESSION['Uchplan_soderzhanie']['filter']['chassem2'];
}else{
	$chassem2='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['chassem3']=='on'){
	$chassem3=$_SESSION['Uchplan_soderzhanie']['filter']['chassem3'];
}else{
	$chassem3='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['chassem4']=='on'){
	$chassem4=$_SESSION['Uchplan_soderzhanie']['filter']['chassem4'];
}else{
	$chassem4='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['chassem5']=='on'){
	$chassem5=$_SESSION['Uchplan_soderzhanie']['filter']['chassem5'];
}else{
	$chassem5='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['chassem6']=='on'){
	$chassem6=$_SESSION['Uchplan_soderzhanie']['filter']['chassem6'];
}else{
	$chassem6='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['chassem7']=='on'){
	$chassem7=$_SESSION['Uchplan_soderzhanie']['filter']['chassem7'];
}else{
	$chassem7='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['chassem8']=='on'){
	$chassem8=$_SESSION['Uchplan_soderzhanie']['filter']['chassem8'];
}else{
	$chassem8='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['zachsem1']=='on'){
	$zachsem1=$_SESSION['Uchplan_soderzhanie']['filter']['zachsem1'];
}else{
	$zachsem1='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['zachsem2']=='on'){
	$zachsem2=$_SESSION['Uchplan_soderzhanie']['filter']['zachsem2'];
}else{
	$zachsem2='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['zachsem3']=='on'){
	$zachsem3=$_SESSION['Uchplan_soderzhanie']['filter']['zachsem3'];
}else{
	$zachsem3='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['zachsem4']=='on'){
	$zachsem4=$_SESSION['Uchplan_soderzhanie']['filter']['zachsem4'];
}else{
	$zachsem4='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['zachsem5']=='on'){
	$zachsem5=$_SESSION['Uchplan_soderzhanie']['filter']['zachsem5'];
}else{
	$zachsem5='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['zachsem6']=='on'){
	$zachsem6=$_SESSION['Uchplan_soderzhanie']['filter']['zachsem6'];
}else{
	$zachsem6='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['zachsem7']=='on'){
	$zachsem7=$_SESSION['Uchplan_soderzhanie']['filter']['zachsem7'];
}else{
	$zachsem7='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['zachsem8']=='on'){
	$zachsem8=$_SESSION['Uchplan_soderzhanie']['filter']['zachsem8'];
}else{
	$zachsem8='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kurssem1']=='on'){
	$kurssem1=$_SESSION['Uchplan_soderzhanie']['filter']['kurssem1'];
}else{
	$kurssem1='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kurssem2']=='on'){
	$kurssem2=$_SESSION['Uchplan_soderzhanie']['filter']['kurssem2'];
}else{
	$kurssem2='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kurssem3']=='on'){
	$kurssem3=$_SESSION['Uchplan_soderzhanie']['filter']['kurssem3'];
}else{
	$kurssem3='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kurssem4']=='on'){
	$kurssem4=$_SESSION['Uchplan_soderzhanie']['filter']['kurssem4'];
}else{
	$kurssem4='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kurssem5']=='on'){
	$kurssem5=$_SESSION['Uchplan_soderzhanie']['filter']['kurssem5'];
}else{
	$kurssem5='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kurssem6']=='on'){
	$kurssem6=$_SESSION['Uchplan_soderzhanie']['filter']['kurssem6'];
}else{
	$kurssem6='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kurssem7']=='on'){
	$kurssem7=$_SESSION['Uchplan_soderzhanie']['filter']['kurssem7'];
}else{
	$kurssem7='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kurssem8']=='on'){
	$kurssem8=$_SESSION['Uchplan_soderzhanie']['filter']['kurssem8'];
}else{
	$kurssem8='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kontrsem1']=='on'){
	$kontrsem1=$_SESSION['Uchplan_soderzhanie']['filter']['kontrsem1'];
}else{
	$kontrsem1='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kontrsem2']=='on'){
	$kontrsem2=$_SESSION['Uchplan_soderzhanie']['filter']['kontrsem2'];
}else{
	$kontrsem2='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kontrsem3']=='on'){
	$kontrsem3=$_SESSION['Uchplan_soderzhanie']['filter']['kontrsem3'];
}else{
	$kontrsem3='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kontrsem4']=='on'){
	$kontrsem4=$_SESSION['Uchplan_soderzhanie']['filter']['kontrsem4'];
}else{
	$kontrsem4='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kontrsem5']=='on'){
	$kontrsem5=$_SESSION['Uchplan_soderzhanie']['filter']['kontrsem5'];
}else{
	$kontrsem5='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kontrsem6']=='on'){
	$kontrsem6=$_SESSION['Uchplan_soderzhanie']['filter']['kontrsem6'];
}else{
	$kontrsem6='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kontrsem7']=='on'){
	$kontrsem7=$_SESSION['Uchplan_soderzhanie']['filter']['kontrsem7'];
}else{
	$kontrsem7='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['kontrsem8']=='on'){
	$kontrsem8=$_SESSION['Uchplan_soderzhanie']['filter']['kontrsem8'];
}else{
	$kontrsem8='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['examsem1']=='on'){
	$examsem1=$_SESSION['Uchplan_soderzhanie']['filter']['examsem1'];
}else{
	$examsem1='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['examsem2']=='on'){
	$examsem2=$_SESSION['Uchplan_soderzhanie']['filter']['examsem2'];
}else{
	$examsem2='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['examsem3']=='on'){
	$examsem3=$_SESSION['Uchplan_soderzhanie']['filter']['examsem3'];
}else{
	$examsem3='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['examsem4']=='on'){
	$examsem4=$_SESSION['Uchplan_soderzhanie']['filter']['examsem4'];
}else{
	$examsem4='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['examsem5']=='on'){
	$examsem5=$_SESSION['Uchplan_soderzhanie']['filter']['examsem5'];
}else{
	$examsem5='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['examsem6']=='on'){
	$examsem6=$_SESSION['Uchplan_soderzhanie']['filter']['examsem6'];
}else{
	$examsem6='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['examsem7']=='on'){
	$examsem7=$_SESSION['Uchplan_soderzhanie']['filter']['examsem7'];
}else{
	$examsem7='';
}
if($_SESSION['Uchplan_soderzhanie']['filter_check']['examsem8']=='on'){
	$examsem8=$_SESSION['Uchplan_soderzhanie']['filter']['examsem8'];
}else{
	$examsem8='';
}
$dbuch_cont->add( $plann,  $indexplan,  $predmet,  $theory,  $praktik,  $kursov,  $samost,  $kolvokontrol,  $chassem1,  $chassem2,  $chassem3,  $chassem4,  $chassem5,  $chassem6,  $chassem7,  $chassem8,  $zachsem1,  $zachsem2,  $zachsem3,  $zachsem4,  $zachsem5,  $zachsem6,  $zachsem7,  $zachsem8,  $kurssem1,  $kurssem2,  $kurssem3,  $kurssem4,  $kurssem5,  $kurssem6,  $kurssem7,  $kurssem8,  $kontrsem1,  $kontrsem2,  $kontrsem3,  $kontrsem4,  $kontrsem5,  $kontrsem6,  $kontrsem7,  $kontrsem8,  $examsem1,  $examsem2,  $examsem3,  $examsem4,  $examsem5,  $examsem6,  $examsem7,  $examsem8);
	}
}
?>