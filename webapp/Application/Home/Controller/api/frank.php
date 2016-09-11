<?php
require_once 'functions.php';
require_once 'pdo.php';



function getStuInfo($stuNum=''){
	$pdo=new proPdo();
	if($stuNum==''){
		$arr['r']=-1;
		$arr['msg']='参数错误';
		return $arr;
	}
	try {
		$arr=$pdo->doSql("select * from stu_info where stu_num='{$stuNum}'");
		if(count($arr)==0){
			$arr[0]['r']=0;
			$arr[0]['msg']='不存在该用户信息';
		}
		else {
			$arr[0]['r']=1;
			$arr[0]['msg']='查询成功';
		}
		return $arr[0];
	} catch (Exception $e) {
		$arr=$pdo->doSql("select * from stu_info where stu_num='{$stuNum}'");
		$arr[0]['r']=0;
		$arr[0]['msg']='查询失败';
		return $arr[0];
	}
}
?>