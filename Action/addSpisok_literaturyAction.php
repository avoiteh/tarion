<?php
class addSpisok_literaturyAction{
	function Go(){
		$dbbiblio=new dbbiblio();
if($_SESSION['Spisok_literatury']['filter_check']['booktype']=='on'){
	$booktype=$_SESSION['Spisok_literatury']['filter']['booktype'];
}else{
	$booktype=0;
}
if($_SESSION['Spisok_literatury']['filter_check']['author']=='on'){
	$author=$_SESSION['Spisok_literatury']['filter']['author'];
}else{
	$author='';
}
if($_SESSION['Spisok_literatury']['filter_check']['title']=='on'){
	$title=$_SESSION['Spisok_literatury']['filter']['title'];
}else{
	$title='';
}
if($_SESSION['Spisok_literatury']['filter_check']['dataizd']=='on'){
	$dataizd=$_SESSION['Spisok_literatury']['filter']['dataizd'];
}else{
	$dataizd=0;
}
if($_SESSION['Spisok_literatury']['filter_check']['izdatel']=='on'){
	$izdatel=$_SESSION['Spisok_literatury']['filter']['izdatel'];
}else{
	$izdatel='';
}
if($_SESSION['Spisok_literatury']['filter_check']['grif']=='on'){
	$grif=$_SESSION['Spisok_literatury']['filter']['grif'];
}else{
	$grif=0;
}
if($_SESSION['Spisok_literatury']['filter_check']['kolvo']=='on'){
	$kolvo=$_SESSION['Spisok_literatury']['filter']['kolvo'];
}else{
	$kolvo=0;
}
if($_SESSION['Spisok_literatury']['filter_check']['libcat']=='on'){
	$libcat=$_SESSION['Spisok_literatury']['filter']['libcat'];
}else{
	$libcat=0;
}
$dbbiblio->add( $booktype,  $author,  $title,  $dataizd,  $izdatel,  $grif,  $kolvo,  $libcat);
	}
}
?>