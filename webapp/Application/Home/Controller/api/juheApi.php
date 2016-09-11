<?php
/*require_once*/

require_once 'functions.php';

/*各种接口的调用*/


//dump(getIpAddrInfo("www.hifrank.com")['result']['area']);


/**
 * 图灵机器人自动回复
 * @param string $info 你要输入的关键字
 * @return string 回复的字符串
 * [聚合API]:  https://www.juhe.cn/docs/api/id/112
 */
function getRootTurin($info){
	$requestURL="http://op.juhe.cn/robot/index?key=bb223723998cc19297a0deaedb301982&info=".$info;
	$replyArr=json_decode(getJson($requestURL),true);
	return $replyArr['result']['text'];
}


/**
 * 根据IP/域名查询地址
 * @param string $url 请求链接地址
 * @return array 回复的字符串
 * [聚合API]:  https://www.juhe.cn/docs/api/id/1
 * 
 * 返回数据格式：
 * 	{
 * 		"resultcode":"200",
 * 		"reason":"Return Successd!",
 * 		"result":{
 * 			"area":"广东省深圳市",
 * 			"location":"腾讯公司"
 * 		},
 * 		"error_code":0
 * 	}
 * 
 * 调用例如：getIpAddrInfo("www.hifrank.com")['result']['area'];
 */
function getIpAddrInfo($url){
	$requestURL="http://apis.juhe.cn/ip/ip2addr?key=c9ac585ca97281b6f8d9b9117d4908ea&ip=".$url;
	return $replyArr=json_decode(getJson($requestURL),true);
}




/**
 *百度语音接口
 *http://tts.baidu.com/text2audio?lan=zh&ie=UTF-8&spd=4&text=123
 *QQ头像接口
 *http://q2.qlogo.cn/headimg_dl?bs=1&src_uin=1&fid=1&spec=100&url_enc=0&referer=bu_interface&term_type=PC&dst_uin=1002039945
 */



?>