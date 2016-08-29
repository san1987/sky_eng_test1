<?php
require_once "config.php";

mysql_connect ($db_server, $db_user, $db_pass) ;
mysql_select_db($db_name);

function mq($sql){
	$r=mysql_query($sql);
	if ($e=mysql_errno()){
		echo("<br>Error: $sql \n<br> ". mysql_error() ."<br>");
	}
	return $r;
}

function mres($s){
	return mysql_real_escape_string($s);
}

function fetch($r){
	return mysql_fetch_assoc($r);
}