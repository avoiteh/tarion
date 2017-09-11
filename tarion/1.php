<?php
phpinfo();
?>{"id":"BO","mode":"get"}<?php
session_start();
require_once('connect_db.php');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=utf-8');


header("Content-Coding: gzip");
//Р вЂўРЎРѓР В»Р С‘ РЎРѓРЎвЂљР ВµРЎР‚Р Р†Р ВµРЎР‚ Р С—Р С•Р Т‘Р Т‘Р ВµРЎР‚Р В¶Р С‘Р Р†Р В°Р ВµРЎвЂљ - РЎРЊРЎвЂљР С• Р С—Р С•Р С