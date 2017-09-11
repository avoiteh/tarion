<?php
function makeAuthBlocks(){
	copy("scripts/Prototype/authBO.php", "../authBO.php");
	copy("scripts/Prototype/authFO.php", "../authFO.php");
	copy("scripts/Prototype/capche.php", "../capche.php");
	copy("scripts/Prototype/lib.php", "../lib.php");
	copy("scripts/Prototype/tbl_change.js", "../tbl_change.js");
	copy("scripts/Prototype/calendar.php", "../calendar.php");
	copy("images/b_calendar.png", "../images/b_calendar.png");
	copy("images/b_edit.png", "../images/b_edit.png");
	copy("images/b_drop.png", "../images/b_drop.png");
	copy("style.css", "../style.css");
}
?>