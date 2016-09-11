<?php
namespace Home\Controller;
use Think\Controller;
class PageController extends Controller {

public function index() {
$server = $_SERVER['SERVER_NAME'];
echo $server;
}

//修改密码
public function upPwd(){
$uname = $_POST['username'];
$oldpwd = $_POST['oldpw'];
$pwd = $_POST['password'];
$User = M();
$date = $User->query("SELECT dbo.att_userinfo.password FROM dbo.att_userinfo WHERE dbo.att_userinfo.userid='{$uname}'");
if(!isset($date) || $date==array()){
$ret = array(code => 0, msg => '账号不存在！');
$this->json_return();
}
}


/**
 *
 * @api {post} /Home/Page?action=getUserInfoByUserid
 * @apiDescription 获取图书信息
 * @apiGroup User
 * @apiName getUserInfoByUserid
 * @apiParam {String} book_id 图书数据库id编号
 * @apiParam {String} book_id 图书数据库id编号
 * @apiVersion 0.1.0
 * @apiExample {curl} 访问示例：
 * curl -i http://hzrrkj.gnway.cc:8080/?action=getUserInfoByUserid
 * @apiSuccess {JSON} JsonStr 返回JSON数据
 */
public function getUserInfoByUserid() {
$conn = M();
}



public function  json_return($arr){
echo json_encode($arr);
exit();
}
/**
 * 获取接口json格式的数据
 * @param url 接口地址
 */
function getJson($url) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22");
curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //加入gzip解析
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($ch);
curl_close($ch);
return $output;
}
}