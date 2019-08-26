<?php
//core
function dbcon(){
	$host="localhost";
	$user="root";
	$pass="";
	$db_name="cman";
	$mysqli=new mysqli($host,$user,$pass,$db_name);
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
