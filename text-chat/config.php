<?php
// ini_set("display_errors","on");
$docRoot	= realpath(dirname(__FILE__));
if( !isset($dbh) ){
	session_start();
	date_default_timezone_set("UTC");
	$musername = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
	$mpassword = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
	$hostname  = getenv('OPENSHIFT_MYSQL_DB_HOST');
	$dbname    = getenv('OPENSHIFT_GEAR_NAME');
	$port      = getenv('OPENSHIFT_MYSQL_DB_PORT');
	$dbh		= new PDO("mysql:dbname={$dbname};host={$hostname};port={$port}", $musername, $mpassword);
	/* Change The Credentials to connect to database. */
	//include_once "$docRoot/inc/startServer.php";
}
?>