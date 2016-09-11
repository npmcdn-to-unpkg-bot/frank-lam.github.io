 <?php
 
 	require_once "api/functions.php";
 	require_once "api/weixinApi.php";
 	require_once "api/juheApi.php";
 	// require_once "api/frank.php";
 
 	//创建数据库对象
 	// $pdo=new proPdo();
 
 	// echo 'webchat.php';
 	// exit();
 
 	$options = array(
 		'token' => 'weixin', //填写你设定的key
 		//'encodingaeskey' => 'xl8NpkjubyNByTvSC66TU7F0rDdakQNgPY1kGj8UMjg', //填写加密用的EncodingAESKey
 		'appid' => 'wx7707f2ecab46b656', //填写高级调用功能的app id
 		'appsecret' => 'b431244be757bc5ab9403c87d5c8aacd' //填写高级调用功能的密钥
 	);
 
 	$wxchat = new Wechat($options);
 	$wxchat -> valid();
 	$type = $wxchat -> getRev() -> getRevType();
 
 	switch($type) {
 		
 		/* 消息类型：text */
 		case Wechat::MSGTYPE_TEXT :
 			$keyword=$wxchat -> getRevContent();
 			$openid=$wxchat -> getRevFrom();
 			$userInfoArr= $wxchat -> getUserInfo($openid);
 
 			// {subscribe,openid,nickname,sex,city,province,country,language,headimgurl,subscribe_time,[unionid]}
 
 			// $headimgurl=$userInfoArr['headimgurl'];
 			// $city=$userInfoArr['city'];
 			// $wxchat -> text($headimgurl) -> reply();
 
 
 			//调用图灵机器人接口
 			// $replyString=getRootTurin($keyword);
 
 			$sub_time=date("Y-m-d H:i:s", $userInfoArr['subscribe_time']);
 			$wxchat->text($sub_time)->reply();
 
 
 
 			// $replyArr=getStuInfo($keyword);
 			// if($replyArr['r']==1){
 			// 	$re='【查询成功】'."\n".'学号：'.$replyArr['stu_num']."\n".'姓名：'.$replyArr['stu_name']."\n".'手机：'.$replyArr['stu_tel']."\n".'寝室：'.$replyArr['stu_dom'];
 			// }
 			// else {
 			// 	$re=$replyArr['msg'];
 			// }
 
 
 
 			// //回复用户文本
 			// $wxchat -> text($re) -> reply();
 
 			
 			// $args =array(
 			// 	'openid' =>$openid,
 			// 	'keyword' =>$keyword,
 			// 	're' => $re
 			// );
 			// $pdo-> insert('wx_text',$args);
 			break;
 
 
 
 		/* 消息类型：event */
 		case Wechat::MSGTYPE_EVENT :
 		// //获取事件详细
 			$eventArr=$wxchat->getRevEvent();
 			$event=$eventArr['event'];
 			$eventKey=$eventArr['key'];
 
 			if($event=='CLICK'){
 				// $replyString='点击事件2';
 				$openid=$wxchat -> getRevFrom();
 				$userInfoArr= $wxchat -> getUserInfo($openid);
 				$headimgurl=$userInfoArr['headimgurl'];
 				$nickname=$userInfoArr['nickname'];
 				$sex=$userInfoArr['sex'];
 				$country=$userInfoArr['country'];
 				$province=$userInfoArr['province'];
 				$city=$userInfoArr['city'];

				$url="http://att.renrunkeji.cn/webapp/login.html"."?headimgurl=".$headimgurl;
				$url=$url."&nickname=$nickname";
				$url=$url."&sex=$sex";
				$url=$url."&country=$country";
				$url=$url."&province=$province";
				$url=$url."&city=$city";
				$url=$url."&openid=$openid";

				$replyString="<a href='{$url}'>仁润webapp1.0正式上线，点我开始体验吧！</a>";
 			}
 
 			
 			if($event==Wechat::EVENT_SUBSCRIBE){
 				$replyString='终于等到你，欢迎加入仁论堂~仁润员工内部在线社区webapp1.0正式上线，欢迎大家的加入，有想法或者点子可以直接回复给我们。';
 			}
 			if($event==Wechat::EVENT_SUBSCRIBE && substr($eventKey, 0,8)=='qrscene_'){
 				$replyString='您之前未订阅公众号，扫描了带参数的二维码';
 
 			}
 			if($event=='SCAN'){
 				$replyString='你已经关注，场景值为：'.$wxchat->getRevSceneId();
 			}
 
 			$wxchat -> text($replyString) -> reply();
 			break;
 
 
 		/* 消息类型：image */
 		case Wechat::MSGTYPE_IMAGE :
 			break;
 		// default :
 		// $wxchat -> text("help info") -> reply();
 	}
 
 	//获取菜单操作:
 	$menu = $wxchat -> getMenu();
 	//设置菜单
 	$newmenu = array("button" => array( array('type' => 'click', 'name' => 'webapp1.0开始体验', 'key' => 'MENU_KEY_NEWS') ));
 	$result = $wxchat -> createMenu($newmenu);
 	// $result = $wxchat -> deleteMenu();
 
 
 
 	// $menu = $wxchat->getMenu();
 	// //设置菜单
 	// $newmenu =  array(
 	//         "button"=>
 	//             array(
 	//                 array('type'=>'click','name'=>'最新消息','key'=>'MENU_KEY_NEWS'),
 	//                 array('type'=>'view','name'=>'我要搜索','url'=>'http://www.baidu.com'),
 	//                 )
 	//        );
 	// $result = $wxchat->createMenu($newmenu);
 ?>