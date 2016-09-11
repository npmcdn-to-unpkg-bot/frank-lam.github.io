<?php

$id = intval($_REQUEST['id']);


require_once 'api/pdo.php';
require_once 'api/functions.php';

$pdo=new proPdo();
$sql = "delete from users where id=$id";
$result=$pdo->doSql($sql);
if ($result>0){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>'Some errors occured.'));
}
?>



