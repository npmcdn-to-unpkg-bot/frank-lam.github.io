<?php

$firstname = $_REQUEST['firstname'];
$lastname = $_REQUEST['lastname'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];

// include 'conn.php';

// $sql = "insert into users(firstname,lastname,phone,email) values('$firstname','$lastname','$phone','$email')";
// $result = @mysql_query($sql);
// if ($result){
// 	echo json_encode(array('success'=>true));
// } else {
// 	echo json_encode(array('msg'=>'Some errors occured.'));
// }



require_once 'api/pdo.php';
require_once 'api/functions.php';

$pdo=new proPdo();
$data=$pdo->doSql("insert into users(firstname,lastname,phone,email) values('$firstname','$lastname','$phone','$email')");
if ($data>0){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>'Some errors occured.'));
}


?>