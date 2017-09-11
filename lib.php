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
"à" => "a",
"á" => "b",
"â" => "v",
"ã" => "g",
"ä" => "d",
"å" => "e",
"¸" => "e",
"æ" => "zh",
"ç" => "z",
"è" => "i",
"é" => "y",
"ê" => "k",
"ë" => "l",
"ì" => "m",
"í" => "n",
"î" => "o",
"ï" => "p",
"ð" => "r",
"ñ" => "s",
"ò" => "t",
"ó" => "u",
"ô" => "f",
"õ" => "kh",
"ö" => "ts",
"÷" => "ch",
"ø" => "sh",
"ù" => "shch",
"û" => "y",
"ý" => "e",
"þ" => "yu",
"ÿ" => "ya",
"À" => "A",
"Á" => "B",
"Â" => "V",
"Ã" => "G",
"Ä" => "D",
"Å" => "E",
"¨" => "E",
"Æ" => "Zh",
"Ç" => "Z",
"È" => "I",
"É" => "Y",
"Ê" => "K",
"Ë" => "L",
"Ì" => "M",
"Í" => "N",
"Î" => "O",
"Ï" => "P",
"Ð" => "R",
"Ñ" => "S",
"Ò" => "T",
"Ó" => "U",
"Ô" => "F",
"Õ" => "Kh",
"Ö" => "Ts",
"×" => "Ch",
"Ø" => "Sh",
"Ù" => "Shch",
"Û" => "Y",
"Ý" => "E",
"Þ" => "Yu",
"ß" => "Ya",
"ü" => "",
"Ü" => "",
"ú" => "",
"Ú" => ""
 );
	if(preg_match("/[à-ÿÀ-ß]/", $text)){
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