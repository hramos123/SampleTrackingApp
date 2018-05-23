<?php
session_start();
$_SESSION['username'] = $_POST['user'];
$_SESSION['password'] = $_POST['pass'];
$_SESSION['aid'] = 0;

include "global.php";

$admin=mysql_fetch_object(mysql_query("select * from admin where id='1'"));

$ruser = $admin->username;
$rpass = $admin->password;

if ($_SESSION['username'] == $ruser && $_SESSION['password'] == $rpass) {
   $_SESSION['aid'] = 1;
	 header("location:../index.php");
}
else {
	header("location:../admin_login.php?passcheck");
  }

?>