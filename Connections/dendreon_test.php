<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dendreon_test = "****";
$database_dendreon_test = "****";
$username_dendreon_test = "****";
$password_dendreon_test = "****";
$dendreon_test = mysql_pconnect($hostname_dendreon_test, $username_dendreon_test, $password_dendreon_test) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_set_charset('utf8',$dendreon_test);
mysql_select_db($database_dendreon_test, $dendreon_test);
?>