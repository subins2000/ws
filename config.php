<?php
ini_set("display_errors","on");
$docRoot	= realpath(dirname(__FILE__));

if( !isset($dbh) ){
	session_start();
	date_default_timezone_set("UTC");
	$musername = getenv('OPENSHIFT_MYSQL_DB_USERNAME') ?:"root";
	$mpassword = getenv('OPENSHIFT_MYSQL_DB_PASSWORD') ?:"backstreetboys";
	$hostname  = getenv('OPENSHIFT_MYSQL_DB_HOST') ?:"127.0.0.1";
	$dbname    = getenv('OPENSHIFT_GEAR_NAME') ?:"test";
	$port      = getenv('OPENSHIFT_MYSQL_DB_PORT') ?:"3306";

	$dbh = new PDO("mysql:dbname={$dbname};host={$hostname};port={$port}", $musername, $mpassword);
	/**
   * Change The Credentials to connect to database.
   */
}
?>
