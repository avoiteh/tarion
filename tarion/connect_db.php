<?php
$CFG=unserialize(file_get_contents('tarion.cfg'));

$dbh=mysql_connect ($CFG['dbhost'], $CFG['dblogin'], $CFG['dbpassword']) or die ('I cannot connect to the database because: '. mysql_error()."<hr>host: $CFG[dbhost]<br>login: $CFG[dblogin]<br>password: $CFG[dbpassword]"); 
mysql_select_db ($CFG['database']) or die("ньхайю ондйкчвемхъ й ад, line: ".__LINE__."<hr>".mysql_error()); 
?>