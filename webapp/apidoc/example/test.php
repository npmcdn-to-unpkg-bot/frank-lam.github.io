<?php
/**
 *
 * @api {post} /?action=login
 * @apiDescription 用户登录
 * @apiGroup Att
 * @apiName login
 * @apiParam {String} userid 账号
 * @apiParam {String} password 密码
 * @apiVersion 0.1.0
 *
 *
 * @apiExample {curl} 访问示例：
 * curl -i http://hzrrkj.gnway.cc:8080/?action=login
 *
 * @apiSuccess {String} code 返回码，1成功，0失败
 * @apiSuccess {String} msg  错误信息
 */
function login(){
	$userid=$_GET['userid'];
	$password=$_GET['password'];

	if(!isset($userid)&&isset($password)){
	    $re=array('code' => '-1' ,'msg' => '请输入账号[userid]' );
	    echo json_encode($re);
	    return;
	}
	if(isset($userid)&&!isset($password)){
	    $re=array('code' => '-1' ,'msg' => '请输入账号[password]' );
	    echo json_encode($re);
	    return;
	}

	if($userid=='' || $password==''){
	    $re=array('code' => '0' ,'msg' => '用户名[userid]和密码[password]字段不得为空' );
	    echo json_encode($re);
	    return;
	}

	if(isset($userid)&& isset($password)){
	    $User=M();
	    $data=$User->query("select * from att_userinfo where userid='{$userid}'");
	    $userIsExist=count($data);
	    if($userIsExist==0){
	        $re=array('code' => '0' ,'msg' => '用户名不存在' );
	        echo json_encode($re);
	        return;
	    }
	    else {
	        $realPassword=$data[0]['password'];
	        if($realPassword==$password){
	            session_start();
	            // 存储 session 数据
	            $_SESSION['userid']=$userid;
	            $re=array('code' => '1' ,'msg' => '登录成功' );
	            $this->loginLog();

	            echo json_encode($re);
	            // write_login_session();
	            return;
	        }
	        if($realPassword!=$password){
	            $re=array('code' => '0' ,'msg' => '密码错误' );
	            echo json_encode($re);
	            // write_login_session();
	            return;
	        }
	    }

	    // dump($data);

	    // $re=array('code' => '1' ,'msg' => '已经设置账号密码' );
	    // echo json_encode($re);
	}
	else {
	    $re=array('code' => '0' ,'msg' => '请输入必填项目[userid]和[password]' );
	    echo json_encode($re);
	    return;
	}
}