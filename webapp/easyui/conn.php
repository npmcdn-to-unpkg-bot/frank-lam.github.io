<?php

$conn = @mysql_connect('127.02.0.1','root','root');
var_dump($conn);
echo mysql_error();
if (!$conn) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('user', $conn);

?>