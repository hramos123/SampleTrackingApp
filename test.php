<?php
ini_set('error_log', '');
ini_set('display_errors', 'Off');
phpinfo();
$fixture = array();
assertTrue(count($fixture) == 0);
 
$fixture[] = 'element';
assertTrue(count($fixture) == 2);
 
function assertTrue($condition)
{
    if (!$condition) {
		print("assertion failed");
        throw new Exception('Assertion failed.');
    }
}
?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>