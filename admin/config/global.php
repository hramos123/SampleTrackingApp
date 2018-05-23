<?php
	$Global['debug'] = true;
	$Global['debug_to'] = "****";//, sletarte@dendreon.com";
	$Global['host']="****"; //50.116.98.111;
	$Global['username']='****';  //hramos
	$Global['password']='****'; //abracadabra
	$Global['database']='****';//SampleSubmissionTracking 
	$Global['baseurl']='http://www.thirdhelixcoders.com/SampleTrackingApp/'; //http://sea11heptagon/SampleSubmissionTracker/

$connhandle=mysql_connect($Global['host'],$Global['username'],$Global['password'])or die('can\'t establish connection with mysql');
$dbSelect=mysql_select_db($Global['database'],$connhandle) or die('could not connect to the database');
?>