<?php
/**
* transliterate text
*
* @param string $text
* @return string
*/
function translit($text) {
	$lat='QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890_';
	$trans = array(
"�" => "a",
"�" => "b",
"�" => "v",
"�" => "g",
"�" => "d",
"�" => "e",
"�" => "e",
"�" => "zh",
"�" => "z",
"�" => "i",
"�" => "y",
"�" => "k",
"�" => "l",
"�" => "m",
"�" => "n",
"�" => "o",
"�" => "p",
"�" => "r",
"�" => "s",
"�" => "t",
"�" => "u",
"�" => "f",
"�" => "kh",
"�" => "ts",
"�" => "ch",
"�" => "sh",
"�" => "shch",
"�" => "y",
"�" => "e",
"�" => "yu",
"�" => "ya",
"�" => "A",
"�" => "B",
"�" => "V",
"�" => "G",
"�" => "D",
"�" => "E",
"�" => "E",
"�" => "Zh",
"�" => "Z",
"�" => "I",
"�" => "Y",
"�" => "K",
"�" => "L",
"�" => "M",
"�" => "N",
"�" => "O",
"�" => "P",
"�" => "R",
"�" => "S",
"�" => "T",
"�" => "U",
"�" => "F",
"�" => "Kh",
"�" => "Ts",
"�" => "Ch",
"�" => "Sh",
"�" => "Shch",
"�" => "Y",
"�" => "E",
"�" => "Yu",
"�" => "Ya",
"�" => "",
"�" => "",
"�" => "",
"�" => ""
 );
	if(preg_match("/[�-��-�]/", $text)){
		$s=strtr($text, $trans);
	}else{
		$s=$text;
	}
	for ($i=0;$i<strlen($s);$i++){
		if(strpos($lat,$s[$i])===false){$s[$i]='_';}
	}
	return $s;
}

function photoPath($photo){
	$path='./photo/'.round($photo/1000);
	if(!file_exists($path)){
		mkdir($path);
		chmod($path, 0777);
	}
	$path.='/'.$photo;
	if(!file_exists($path)){
		mkdir($path);
		chmod($path, 0777);
	}
	return $path;
}

function requireDir($path){
	$d=dir($path);
	while (false !== ($entry = $d->read())) {
		if($entry!='.' && $entry!='..'){
			require_once($path.$entry);
		}
	}
	$d->close();
}
?>