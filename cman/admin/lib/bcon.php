<?php
//core
function dbcon(){
	$user = "root";
	$pass = "";
	$host = "localhost";
	$db = "cman";
	$mysqli=new mysqli($host,$user,$pass,$db);
	// mysql_select_db($db);
}

function host(){
	$h = "http://".$_SERVER['HTTP_HOST']."/bankdb/";
	return $h;
}

function hRoot(){
	$url = $_SERVER['DOCUMENT_ROOT']."/bankdb/";
	return $url;
}

//parse string
function gstr(){
    $qstr = $_SERVER['QUERY_STRING'];
    parse_str($qstr,$dstr);
    return $dstr;
}

?>
