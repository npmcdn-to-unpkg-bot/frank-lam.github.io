<?php

$id = intval($_REQUEST['id']);
$firstname = $_REQUEST['firstname'];
$lastname = $_REQUEST['lastname'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];


require_once 'api/pdo.php';
require_once 'api/functions.php';

$pdo=new proPdo();
$sql = "update users set firstname='$firstname',lastname='$lastname',phone='$phone',email='$email' where id=$id";
$result=$pdo->doSql($sql);
if ($result>0){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>'Some errors occured.'));
}

?>