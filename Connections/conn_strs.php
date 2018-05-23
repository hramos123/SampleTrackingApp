<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_at_hg = "****"; //50.116.98.111";
$database_at_hg = "****";
$username_at_hg = "****";
$password_at_hg = "****";
$at_hg = mysql_pconnect($hostname_at_hg, $username_at_hg, $password_at_hg) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_set_charset('utf8',$at_hg);
mysql_select_db($database_at_hg, $at_hg);
?>