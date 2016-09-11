<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller
{

    public function index() {

        //读取全部配置项
        // $config=C('');
        // dump($config);

        switch ($_GET['action']) {



            //获取特权套餐信息
            case 'getComboCRUD':
                $this->getComboCRUD();
                break;
            //获取今日特权配置项
            case 'getPrivilegeConfig':
                $this->getPrivilegeConfig();
                break;

            //获取今日特权
            case 'getTodayRankByUserid':
                $this->getTodayRankByUserid();
                break;

            //获取所有用户的信息
            case 'getUserinfo':
                $this->getUserinfo();
                break;

            //判断是否设置头像
            case 'hasSetPortrait':
                $this->hasSetPortrait();
                break;
            // 设置头像URL地址  通过 用户输入的QQ绑定设置
            case 'setPortraitURL':
                $this->setPortraitURL();
                break;
            case 'getAttTodayTopList':
                $this->getAttTodayTopList();
                break;
            case 'getBookinfo':
                $this->getBookinfo();
                break;



            //数据初始化接口
            case 'init':
                $conn=M();
                $r1=$conn->execute("delete from book_library;");
                $r2=$conn->execute("delete from booK_base;");
                if($r1>0 && $r2>0){
                    echo '初始化成功';
                }
                else {
                    echo '当前数据表已经为空，无需初始化。';
                }
                break;

            //用户登录
            case 'login':
                $this->login();
                break;
            //获取今日打卡列表
            case 'getAttRankList':
                $this->getAttRankList();
                break;

            //登录日志
            case 'loginLog':
                $this->loginLog();
                break;
            //初始化登录日志  http://localhost:8088/?action=initLoginLog
            case 'initLoginLog':
                $this->initLoginLog();
                break;

            case 'add_library':
                $this->add_library();
                break;

            case 'getInfoByUserid':
                $this->getInfoByUserid();
                break;
            //获取打卡排名
            case 'getAttRank':
                $this->getAttRank();
                break;
            //获取购书申请审核列表
            case 'getBookApplyList':
                $this->getBookApplyList();
                break;
            //购书申请
            case 'book_application':
                $this->book_application();
                break;


            case 'test':
                dump(getInfoByUserid("llc73"));
                break;
            //插入微信的信息到 att_userinfo表
            case 'addWeixinInfo':
                $this->addWeixinInfo();
                break;
            //删除 att_userinfo的微信信息字段
            case 'delWeixinInfo':
                $this->delWeixinInfo();
                break;
            case 'tryLoginWeixin':
                $this->tryLoginWeixin();
                break;
            case 'doExec':
                $this->doExec();
                break;

            case 'update_breakfast':
                $this->update_breakfast();
                break;
            //已选早餐
            case 'select_breakfast':
                $this->select_breakfast();
                break;
            //今日已选套餐数量
            case 'date_breakfast':
                $this->date_breakfast();
            case 'doQuery':
                $this->doQuery();
                break;
            default:
                // code...
                echo 'sorry,parameter error';


            break;
        }
    }





/**
 *
 * @api {get} /?action=getComboCRUD 早饭套餐的CRUD
 * @apiDescription 早饭套餐的CRUD
 * @apiGroup ATT PRIVILEGE
 * @apiName getComboCRUD
 * @apiVersion 0.1.0
 *
 * @apiParam {string} type type:read|update 
 * @apiExample {curl} 访问示例：
 * curl -i http://hzrrkj.gnway.cc:8080/?action=getComboCRUD
 *
 * @apiSuccess {json} data json数组对象
 */
public function getComboCRUD(){
    $conn=M();
    $type=$_GET['type'];
    // $type='read';
    if($type=='read'){
        $re=$conn->query("select * from att_privilege_combo");
        $this->json_return($re);
    }
    if($type=='update'){
        $id = intval($_POST['id']);
        $comboname = $_POST['comboname'];
        $status = intval($_POST['status']);
        $mark = $_POST['mark'];
        $value = $_POST['value'];
        // echo "update att_privilege_combo set comboname='$comboname',status=$status,mark='$mark',value='$value' where id=$id";
        // exit();
        $result=$conn->execute("update att_privilege_combo set comboname='$comboname',status=$status,mark='$mark',value='$value' where id=$id");



        // if ($result){
        //     echo json_encode(array('success'=>true));
        // } else {
        //     echo json_encode(array('msg'=>'Some errors occured.'));
        // }
        $this->json_return(array('success'=>true));
    }
    if($type=='save'){
        $isNewRecord = $_POST['isNewRecord'];
        $comboname = $_POST['comboname'];
        $status = intval($_POST['status']);
        $mark = $_POST['mark'];
        $value = $_POST['value'];
        // echo "update att_privilege_combo set comboname='$comboname',status=$status,mark='$mark',value='$value' where id=$id";
        // exit();
        // echo "insert into att_privilege_combo(comboname,status,mark,value) values('$comboname',$status,'$mark','$value')";
        // exit();
        $result=$conn->execute("insert into att_privilege_combo(comboname,status,mark,value) values('$comboname',$status,'$mark','$value')");



        // if ($result){
        //     echo json_encode(array('success'=>true));
        // } else {
        //     echo json_encode(array('msg'=>'Some errors occured.'));
        // }
        $this->json_return(array('success'=>true));
    }
    if($type=='destroy'){

        $id = intval($_POST['id']);

        // echo "update att_privilege_combo set comboname='$comboname',status=$status,mark='$mark',value='$value' where id=$id";
        // exit();
        // echo "insert into att_privilege_combo(comboname,status,mark,value) values('$comboname',$status,'$mark','$value')";
        // exit();
        $result=$conn->execute("delete from att_privilege_combo where id=$id");



        // if ($result){
        //     echo json_encode(array('success'=>true));
        // } else {
        //     echo json_encode(array('msg'=>'Some errors occured.'));
        // }
        $this->json_return(array('success'=>true));
    }


    $re=array('code' => '0' ,'msg' => '[type]必填项' );
    $this->json_return($re);

}

    /**
     *
     * @api {get} /?action=getPrivilegeConfig 获取早餐特权配置项
     * @apiDescription 获取早餐特权配置项
     * @apiGroup ATT PRIVILEGE
     * @apiName getPrivilegeConfig
     * @apiVersion 0.1.0
     *
     * @apiParam {string} type type:read|update 
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=getPrivilegeConfig
     *
     * @apiSuccess {json} data json数组对象
     */
    public function getPrivilegeConfig(){
        $conn=M();
        $type=$_GET['type'];
        // $type='read';
        if($type=='read'){
            $re=$conn->query("select * from att_privilege_config");
            $this->json_return($re);
        }
        if($type=='update'){
            $id = intval($_REQUEST['id']);
            $privilege_intro = $_REQUEST['privilege_intro'];
            $status = $_REQUEST['status'];
            $begintime = $_REQUEST['begintime'];
            $endtime = $_REQUEST['endtime'];
            $value = $_REQUEST['value'];

            $result=$conn->execute("update att_privilege_config set privilege_intro='$privilege_intro',status=$status,begintime='$begintime',endtime='$endtime',value='$value' where id=$id");
            // if ($result){
            //     echo json_encode(array('success'=>true));
            // } else {
            //     echo json_encode(array('msg'=>'Some errors occured.'));
            // }
            $this->json_return(array('success'=>true));
        }


        $re=array('code' => '0' ,'msg' => '[type]必填项' );
        $this->json_return($re);

    }



    private function getNameByMenu($menu,$whereTimeBe){
    	$conn=M();
    	$test=$conn->query("SELECT att_check.checkam,att_check.privilege_item,att_check.privilege_time,att_userinfo.name FROM att_userinfo INNER JOIN att_check ON att_check.cardid = att_userinfo.cardid where {$whereTimeBe} and privilege_item like '%{$menu}%'");
    	// dump($test);
    	// $namegroup="";


    	foreach ($test as $item) {
    		$namegroup.= $item['name'].',';
    	}
    	return $namegroup;

    }


    /**
     *
     * @api {post} /?action=doQuery 前端SQL查询
     * @apiDescription 前端SQL查询
     * @apiGroup User
     * @apiName doQuery
     * @apiVersion 0.1.0
     *
     * @apiParam {string} sql sql查询语句
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=doQuery
     *
     * @apiSuccess {json} data json数组对象
     */

    public function doQuery(){
        $sql=$_GET['sql'];
        $conn=M();
        $re=$conn->query($sql);
        $this->json_return($re[0]);
    }


    /**
     *
     * @api {post} /?action=date_breakfast 早饭特权统计
     * @apiDescription 早饭特权统计
     * @apiGroup User
     * @apiName date_breakfast
     * @apiVersion 0.1.0
     *
     * @apiParam {string} [date] 日期格式：2016-08-01 或者 2016-8-1，默认：今日
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=date_breakfast
     *
     * @apiSuccess {json} data json数组对象
     */
    public function date_breakfast()
    {   
        $conn=M();
        $date=$_POST['date'];
        if(!varIsAble($date)){
            $date=date('y-m-d',time());
            $startDate=$date." 00:00:00";
            $endDate=date("Y-m-d",strtotime("$date + 1 day"))." 00:00:00";
        }
        else {
            if(!strIsTime($date)){
                $re=array('code' => '0' ,'msg' => '[date]为日期格式，请输入例如：2016-08-01 或者 2016-8-1' );
                $this->json_return($re);
            }
            $startDate=$date." 00:00:00";
            $endDate=date("Y-m-d",strtotime("$date + 1 day"))." 00:00:00";
        }

        $whereTimeBe="att_check.checkam between '{$startDate}' and '{$endDate}'";

        //套餐数量
        $re=$conn->query("select count(*) as count from att_check WHERE att_check.privilege_item LIKE '%套餐1%' and {$whereTimeBe}");
        $menu1=$re[0]['count'];

        // $re=$conn->query("select count(*) as count from att_check WHERE att_check.privilege_item LIKE '%套餐1%' and {$whereTimeBe}");



        // $test=$conn->query("SELECT att_check.checkam,att_check.privilege_item,att_check.privilege_time,att_userinfo.name FROM att_userinfo INNER JOIN att_check ON att_check.cardid = att_userinfo.cardid where {$whereTimeBe} and privilege_item like '%套餐1%'");
        // // dump($test);
        // // $namegroup="";


        // foreach ($test as $item) {
        // 	$namegroup.= $item['name'].',';
        // }



       	// $re=$conn->query("");


        // dump(re[0]);
        // exit();
        $re=$conn->query("select count(*) as count from att_check WHERE att_check.privilege_item LIKE '%套餐2%' and {$whereTimeBe}");
        $menu2=$re[0]['count'];
        $re=$conn->query("select count(*) as count from att_check WHERE att_check.privilege_item LIKE '%套餐3%' and {$whereTimeBe}");
        $menu3=$re[0]['count'];
        $re=$conn->query("select count(*) as count from att_check WHERE att_check.privilege_item LIKE '%套餐4%' and {$whereTimeBe}");
        $menu4=$re[0]['count'];
        $re=$conn->query("select count(*) as count from att_check WHERE att_check.privilege_item LIKE '%套餐5%' and {$whereTimeBe}");
        $menu5=$re[0]['count'];
        $re=$conn->query("select count(*) as count from att_check WHERE att_check.privilege_item LIKE '%套餐6%' and {$whereTimeBe}");
        $menu6=$re[0]['count'];
        $re=$conn->query("select count(*) as count from att_check WHERE att_check.privilege_item LIKE '%套餐7%' and {$whereTimeBe}");
        $menu7=$re[0]['count'];
        //总数量
        $re=$conn->query("select count(*) as count from att_check WHERE att_check.privilege_item LIKE '%套餐%' and {$whereTimeBe}");
        $menu_total=$re[0]['count'];

        $re=array();
        $re[]=array('item'=> '总数' ,'count' => $menu_total );
        $re[]=array('item'=> '套餐1：牛奶' ,'count' => $menu1,'namegroup'=>$this->getNameByMenu('套餐1',$whereTimeBe));
        $re[]=array('item'=> '套餐2：生煎包' ,'count' => $menu2,'namegroup'=>$this->getNameByMenu('套餐2',$whereTimeBe));
        $re[]=array('item'=> '套餐3：小馄饨' ,'count' => $menu3,'namegroup'=>$this->getNameByMenu('套餐3',$whereTimeBe));
        $re[]=array('item'=> '套餐4：葱油拌面' ,'count' => $menu4,'namegroup'=>$this->getNameByMenu('套餐4',$whereTimeBe));
        $re[]=array('item'=> '套餐5：白米粥+茶叶蛋' ,'count' => $menu5,'namegroup'=>$this->getNameByMenu('套餐5',$whereTimeBe));
        $re[]=array('item'=> '套餐6：豆腐花+茶叶蛋' ,'count' => $menu6,'namegroup'=>$this->getNameByMenu('套餐6',$whereTimeBe));
        $re[]=array('item'=> '套餐7：豆浆+茶叶蛋' ,'count' => $menu7,'namegroup'=>$this->getNameByMenu('套餐7',$whereTimeBe));


        $this->json_return($re);


    }

    /**
     *
     * @api {post} /?action=getTodayRankByUserid 获取我的上班打卡排名
     * @apiDescription 获取我的上班打卡排名
     * @apiGroup User
     * @apiName getTodayRankByUserid
     * @apiVersion 0.1.0
     *
     * @apiParam {string} userid 用户名
     * @apiParam {string} [date] 日期格式：2016-08-01 或者 2016-8-1，默认：今日
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=getTodayRankByUserid
     *
     * @apiSuccess {json} data json数组对象
     */
    public function getTodayRankByUserid()
    {
        $conn=M();
        $date=$_POST['date'];
        $userid=$_POST['userid'];


        if(!varIsAble($userid)){
            $re=array('code' => '0' ,'msg' => '[userid]为必填字段' );
            $this->json_return($re);
        }
        else {
            if(!$this->useridIsValid($userid)){
                $re=array('code' => '0' ,'msg' => '[userid]用户名不存在' );
                $this->json_return($re);
            }
        }

        if(!varIsAble($date)){
            $date=date('y-m-d',time());
            $startDate=$date." 00:00:00";
            $endDate=date("Y-m-d",strtotime("$date + 1 day"))." 00:00:00";
        }
        else {
            if(!strIsTime($date)){
                $re=array('code' => '0' ,'msg' => '[date]为日期格式，请输入例如：2016-08-01 或者 2016-8-1' );
                $this->json_return($re);
            }
            $startDate=$date." 00:00:00";
            $endDate=date("Y-m-d",strtotime("$date + 1 day"))." 00:00:00";
        }

        $cardid=strFindNum($userid);

        $re=$conn->query("select rank,checkam from (Select rank=Row_number() Over(order By checkam asc),* From att_check Where checkam between '$startDate' and '$endDate') A where A.cardid=$cardid;");
        $checkam=$re[0]['checkam'];
        
        $re2=array('code' => '1' ,'rank' => $re[0]['rank'] ,'checkam' =>substr($checkam,0,strlen($checkam)-4) , 'checkam_id' =>$checkam);
        $this->json_return($re2);
    }

    /**
     *
     * @api {post} /?action=update_breakfast 提交早饭特权
     * @apiDescription 提交早饭特权表单
     * @apiGroup ATT
     * @apiName update_breakfast
     * @apiVersion 0.1.0
     *
     * @apiParam {string} breakfast_item 早饭选项
     * @apiParam {string} checkam 打卡时间
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=update_breakfast
     *
     * @apiSuccess {json} data json数组对象
     */

    public function update_breakfast()
    {
        $conn=M();
        $checkam=$_POST['checkam'];
        $breakfast_item=$_POST['breakfast_item'];
        if(!varIsAble($checkam)){
            $re=array('code' => '0' ,'msg' => '[checkam]为必填字段' );
            $this->json_return($re);
        }
        if(!varIsAble($breakfast_item)){
            $re=array('code' => '0' ,'msg' => '[breakfast_item]为必填字段' );
            $this->json_return($re);
        }

        $re=$conn->execute("update att_check set privilege_item='$breakfast_item',privilege_time=GETDATE() where checkam='$checkam'");

        if($re>0){
            $re=array('code' => '1' ,'msg' => '提交成功' );
            $this->json_return($re);
        }
        else{
            $re=array('code' => '0' ,'msg' => '提交失败' );
            $this->json_return($re);
        }
    }

    /**
     *
     * @api {post} /?action=select_breakfast 查看已经项选择的早餐项
     * @apiDescription 提交早饭特权表单
     * @apiGroup ATT
     * @apiName select_breakfast
     * @apiVersion 0.1.0
     *
     * @apiParam {string} checkam 打卡时间
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=select_breakfast
     *
     * @apiSuccess {json} data json数组对象
     */
    public function select_breakfast()
    {
        $conn=M();
        $checkam=$_POST['checkam'];
        
        if(!varIsAble($checkam)){
            $re=array('code' => '0' ,'msg' => '[checkam]为必填字段' );
            $this->json_return($re);
        }
        $reback=$conn->query("select privilege_item from att_check where checkam='$checkam'");

        if($reback>0){
            // echo strlen($reback[0]['privilege_item']);
            // exit();
            if(strlen($reback[0]['privilege_item'])==0){
                $re=array('code' => '1' ,'msg' => '查询成功','privilege_item' =>$reback[0]['privilege_item'] ,'show'=>'0' );
            }
            else {
                $re=array('code' => '1' ,'msg' => '查询成功','privilege_item' =>$reback[0]['privilege_item'] ,'show'=>'1' );
            }
            $this->json_return($re);
        }
        else{
            $re=array('code' => '0' ,'msg' => '没有查询到数据' );
            $this->json_return($re);
        }
        // $this->json_return($re);
    }

    public function doExec()
    {
        $conn=M();
        $sql=$_POST['sql'];
        if(!varIsAble($sql)){
            $re=array('code' => '0' ,'msg' => '[sql]为必填字段' );
            $this->json_return($re);
        }
        $re=$conn->execute($sql);
        if($re>0){
            $re=array('code' => '1' ,'msg' => '执行成功' );
            $this->json_return($re);
        }
        else{
            $re=array('code' => '0' ,'msg' => '执行失败' );
            $this->json_return($re);
        }


    }




    public function getUserinfo()
    {
        $CRUD_TYPE=$_GET['crud'];
        if($CRUD_TYPE=='read'){
            $conn=M();
            $re=$conn->query("SELECT B.DEPTNAME AS deptname, A.id,A.cardid, A.name, A.sign, A.userid, A.qq, A.headimgurl, A.nickname, A.sex, A.country, A.province, A.city, A.openid FROM att_userinfo AS A INNER JOIN DEPARTMENTS AS B ON A.departid = B.DEPTID ORDER BY CONVERT(int, A.cardid)");
            $this->json_return($re);
        }
        if($CRUD_TYPE=='edit'){

        }
        else {
            $re=array('code' => '0' ,'msg' => '[crud]为必填字段' );
            $this->json_return($re);
        }
    }


    /**
     *
     * @api {post} /?action=initLoginLog 初始化登录日志
     * @apiDescription 初始化登录日志
     * @apiGroup ATT
     * @apiName initLoginLog
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=initLoginLog
     *
     * @apiSuccess {json} data json数组对象
     */
    public function initLoginLog()
    {
        $conn=M();
        $re=$conn->execute("delete from book_login_log");
        if($re>0){
            $re=array('code' => '1' ,'msg' => '初始化成功' );
            echo json_encode($re);
            return;
        }
        else {
            $re=array('code' => '0' ,'msg' => '当前数据表已经为空，无需初始化' );
            echo json_encode($re);
            return;
        }
    }
    public function hasSetPortrait(){
        $userid=$_GET['userid'];
        $conn=M();

        $re=$conn->query("select * from att_userinfo where userid='{$userid}'");

        // echo $re['qq'];
        // dump($re[]);
        if($re[0]['qq']==""){
            $re=array('code' => '0' ,'msg' => '未设置qq和头像' );
            echo json_encode($re);
            return;
        }
        else{
            $re=array('code' => '1' ,'msg' => '已经设置qq和头像' );
            echo json_encode($re);
            return;
        }
    }
    //通过QQ更新用户  QQ字段  和 头像URL字段
    public function setPortraitURL(){
        $userid=$_GET['userid'];
        $qq=$_GET['qq'];

        if((isset($qq)&&$qq!="")&&(isset($userid)&&$userid!="")){
            $conn=M();
            //$re=$conn->query("SELECT att_userinfo.cardid, att_userinfo.name, DEPARTMENTS.DEPTNAME AS deptname, att_userinfo.password, att_userinfo.userid FROM att_userinfo INNER JOIN DEPARTMENTS ON att_userinfo.departid = DEPARTMENTS.DEPTID where att_userinfo.userid='{$userid}'");

            $portraiturl="http://q2.qlogo.cn/headimg_dl?bs=1&src_uin=1&fid=1&spec=100&url_enc=0&referer=bu_interface&term_type=PC&dst_uin=".$qq;

            $re=$conn->execute("update att_userinfo set qq={$qq},portraiturl='{$portraiturl}' where userid='{$userid}'");
            if($re>0){
                $re=array('code' => '1' ,'msg' => '更新成功' );
                echo json_encode($re);
                return;
            }
            else{
                $re=array('code' => '0' ,'msg' => '不存在该用户名' );
                echo json_encode($re);
                return;
            }
            // $re[0]['code']=1;
            // echo json_encode($re[0]);
            // return;



        }
        else {
            $re=array('code' => '0' ,'msg' => '请输入userid和qq的值' );
            echo json_encode($re);
            return;
        }
    }
    public function write_login_session(){
        echo 'write_login_session';
    }

    public function getAttTodayTopList()
    {
        $conn=M();
        $data=$conn->query("select top(5) * from att_check where (DATEDIFF(dd, checkam, GETDATE()) = 0) order by checkam asc");
        // dump($data);
        echo json_encode($data);
        return;
    }

    /**
     *
     * @api {post} /?action=getInfoByUserid 通过userid获取用户信息
     * @apiDescription 通过userid获取用户信息
     * @apiGroup User
     * @apiName getInfoByUserid
     * @apiVersion 0.1.0
     *
     * @apiParam {string} userid 用户名
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=getInfoByUserid
     *
     * @apiSuccess {json} data json数组对象
     */
    public function getInfoByUserid()
    {
        $userid=$_POST['userid'];
        if(!isset($userid)){
            $userid=$_GET['userid'];
        }

        if(isset($userid)&&$userid!=""){
            $conn=M();
            $re=$conn->query("SELECT att_userinfo.nickname,att_userinfo.sex,att_userinfo.country,att_userinfo.province,att_userinfo.city,att_userinfo.headimgurl,att_userinfo.cardid, att_userinfo.name, DEPARTMENTS.DEPTNAME AS deptname, att_userinfo.password, att_userinfo.userid FROM att_userinfo INNER JOIN DEPARTMENTS ON att_userinfo.departid = DEPARTMENTS.DEPTID where att_userinfo.userid='{$userid}'");
            $re[0]['code']=1;
            echo json_encode($re[0]);
            return;
        }
        else {
            $re=array('code' => '0' ,'msg' => '请输入userid的值' );
            echo json_encode($re);
            return;
        }
    }


    private function loginLog(){
        session_start();

        if(isset($_SESSION['userid'])){
            $userid=$_SESSION['userid'];
        }
        $ipaddr=$_SERVER["REMOTE_ADDR"];

        $conn=M();
        $re=$conn->query("SELECT att_userinfo.cardid, att_userinfo.name, DEPARTMENTS.DEPTNAME AS deptname, att_userinfo.password, att_userinfo.userid FROM att_userinfo INNER JOIN DEPARTMENTS ON att_userinfo.departid = DEPARTMENTS.DEPTID where att_userinfo.userid='{$userid}'");
        // dump($re[0]);

        $name=$re[0]['name'];


        $conn->execute("insert into book_login_log(name,userid,logintime,ip) values('{$name}','{$userid}',getdate(),'{$ipaddr}')");
        return;

    }


    /**
     *
     * @api {post} /?action=getAttRank 每日上班打卡排名
     * @apiDescription 获取每日上班打卡排名
     * @apiGroup ATT
     * @apiName getAttRank
     * @apiParam {string} userid 用户名
     * @apiParam {date} date 时间，格式例如：2016-08-03
     * @apiParam {int} [top] 排名TOP数量，不传值则选择所有
     * @apiParam {string} [order] 排序类型，am上班打卡pm下班打卡
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=getAttRank
     *
     * @apiSuccess {json} data json数组对象
     */
    private function getAttRank(){
        $conn=M();
        $date=$_POST['date'];
        $userid=$_POST['userid'];
        $top=$_POST['top'];
        $order=$_POST['order'];


        if(!varIsAble($userid)){
            $re=array('' => '0' ,'msg' => '[userid]为必填字段' );
            $this->json_return($re);
        }
        else {
            if(!$this->useridIsValid($userid)){
                $re=array('' => '0' ,'msg' => '[userid]用户名不存在' );
                $this->json_return($re);
            }
        }

        if(!varIsAble($date)){
            $re=array('code' => '0' ,'msg' => '[date]为必填字段' );
            $this->json_return($re);
        }
        else {
            if(!strIsTime($date)){
                $re=array('code' => '0' ,'msg' => '[date]为日期格式，请输入例如：2016-08-01 或者 2016-8-1' );
                $this->json_return($re);
            }
            $startDate=$date." 00:00:00";
            $endDate=date("Y-m-d",strtotime("$date + 1 day"))." 00:00:00";
            $whereTimeBe="att_check.checkam between '{$startDate}' and '{$endDate}'";
        }
        // if(!varIsAble($top)){
        //     $re=array('code' => '0' ,'msg' => '[top]排名TOP数量，不传值则选择所有' );
        //     $this->json_return($re);
        // }
        if(varIsAble($top)) {
            $topSQL="top(".$top.")";
            $total=$top;
        }
        else{
            $re2=$conn->query("select {$topSQL} count(*) as total from att_check where {$whereTimeBe};");
            $total=$re2[0]['total'];
        }


        $re=array();
        $re['total']=$total;
        //获取userid的个人信息
        $cardid=strFindNum($userid);
        $re['self']=$conn->query("select att_check.id, att_check.cardid, att_check.checkam, att_check.likeam, att_check.likeam_name, att_check.checkpm, 
                att_check.likepm, att_check.likepm_name, att_check.privilege, att_userinfo.name,att_userinfo.headimgurl,att_userinfo.sign, 
                att_userinfo.departid, att_userinfo.userid, att_userinfo.qq, att_userinfo.portraiturl, att_userinfo.mark
FROM      att_userinfo INNER JOIN
                att_check ON att_userinfo.cardid = att_check.cardid where att_check.cardid={$cardid} and {$whereTimeBe}")[0];
        $re['self_sql']="select * from att_check where cardid={$cardid} and {$whereTimeBe}";


        //获取排名SQL语句：
        //Select * From (Select rank=Row_number() Over(order By checkam asc),* From att_check Where checkam between '2016-08-05 00:00:00' and '2016-08-06 00:00:00' ) A
        $reRank=$conn->query("Select * From (Select rank=Row_number() Over(order By checkam asc),* From att_check Where {$whereTimeBe}  ) A where cardid={$cardid}");
        $re['self']['sql']= "Select * From (Select rank=Row_number() Over(order By checkam asc),* From att_check Where {$whereTimeBe}  ) A where cardid={$cardid}";
        


        $re['self']['rank']=$reRank[0]['rank'];


        if($order=="am" || $order==""){
                    $re['rank']=$conn->query("select {$topSQL} att_check.id, att_check.cardid, att_check.checkam, att_check.likeam, att_check.likeam_name, att_check.checkpm, 
                            att_check.likepm, att_check.likepm_name, att_check.privilege, att_userinfo.name, att_userinfo.sign, 
                            att_userinfo.departid, att_userinfo.userid, att_userinfo.qq, att_userinfo.portraiturl, att_userinfo.mark,att_userinfo.headimgurl
            FROM      att_userinfo INNER JOIN
                            att_check ON att_userinfo.cardid = att_check.cardid where {$whereTimeBe} order by att_check.checkam;");
        }
        else {
                    $re['rank']=$conn->query("select {$topSQL} att_check.id, att_check.cardid, att_check.checkam, att_check.likeam, att_check.likeam_name, att_check.checkpm, 
                            att_check.likepm, att_check.likepm_name, att_check.privilege, att_userinfo.name, att_userinfo.sign, 
                            att_userinfo.departid, att_userinfo.userid, att_userinfo.qq, att_userinfo.portraiturl, att_userinfo.mark,att_userinfo.headimgurl
            FROM      att_userinfo INNER JOIN
                            att_check ON att_userinfo.cardid = att_check.cardid where {$whereTimeBe} order by att_check.checkpm desc;");
        }

        $this->json_return($re);

    }




        /**
         *
         * @api {get} /?action=getAttRankList 获取上班打卡排名列表
         * @apiDescription 获取上班打卡排名列表
         * @apiGroup ATT
         * @apiName getAttRankList
         * @apiParam {date} date 时间，格式例如：2016-08-03
         * @apiParam {int} [top] 排名TOP数量，不传值则选择所有
         * @apiParam {string} [order] 排序类型，am上班打卡pm下班打卡
         * @apiVersion 0.1.0
         *
         *
         * @apiExample {curl} 访问示例：
         * curl -i http://hzrrkj.gnway.cc:8080/?action=getAttRankList
         *
         * @apiSuccess {json} data json数组对象
         */
        private function getAttRankList(){
            $conn=M();
            $date=$_POST['date'];
            $userid=$_GET['userid'];
            $top=$_GET['top'];
            $order=$_GET['order'];


            if(!varIsAble($date)){
                // $re=array('code' => '0' ,'msg' => '[date]为必填字段' );
                // $this->json_return($re);
                $date=date("Y-m-d",time());


                $startDate=$date." 00:00:00";
                $endDate=date("Y-m-d",strtotime("$date + 1 day"))." 00:00:00";
                $whereTimeBe="att_check.checkam between '{$startDate}' and '{$endDate}'";
                // echo gettype($date);
                // exit();
                // echo $date;
                // exit();
            }
            else {
                if(!strIsTime($date)){
                    $re=array('code' => '0' ,'msg' => '[date]为日期格式，请输入例如：2016-08-01 或者 2016-8-1' );
                    $this->json_return($re);
                }
                $startDate=$date." 00:00:00";
                $endDate=date("Y-m-d",strtotime("$date + 1 day"))." 00:00:00";
                $whereTimeBe="att_check.checkam between '{$startDate}' and '{$endDate}'";
            }
            // if(!varIsAble($top)){
            //     $re=array('code' => '0' ,'msg' => '[top]排名TOP数量，不传值则选择所有' );
            //     $this->json_return($re);
            // }
            if(varIsAble($top)) {
                $topSQL="top(".$top.")";
                $total=$top;
            }
            else{
                $re2=$conn->query("select {$topSQL} count(*) as total from att_check where {$whereTimeBe};");
                $total=$re2[0]['total'];
            }


            $re=array();
            // $re['total']=$total;
            //获取userid的个人信息
            $cardid=strFindNum($userid);

            
            if($order=="am" || $order==""){
                        $re=$conn->query("select {$topSQL} att_check.id,att_check.privilege_item, att_check.privilege_time,att_check.cardid, att_check.checkam, att_check.likeam, att_check.likeam_name, att_check.checkpm, 
                                att_check.likepm, att_check.likepm_name, att_check.privilege, att_userinfo.name, att_userinfo.sign, 
                                att_userinfo.departid, att_userinfo.userid, att_userinfo.qq, att_userinfo.portraiturl, att_userinfo.mark,att_userinfo.headimgurl
                FROM      att_userinfo INNER JOIN
                                att_check ON att_userinfo.cardid = att_check.cardid where {$whereTimeBe} order by att_check.checkam;");
            }
            else {
                        $re=$conn->query("select {$topSQL} att_check.id, att_check.privilege_item,att_check.privilege_time, att_check.cardid, att_check.checkam, att_check.likeam, att_check.likeam_name, att_check.checkpm, 
                                att_check.likepm, att_check.likepm_name, att_check.privilege, att_userinfo.name, att_userinfo.sign, 
                                att_userinfo.departid, att_userinfo.userid, att_userinfo.qq, att_userinfo.portraiturl, att_userinfo.mark,att_userinfo.headimgurl
                FROM      att_userinfo INNER JOIN
                                att_check ON att_userinfo.cardid = att_check.cardid where {$whereTimeBe} order by att_check.checkpm desc;");
            }

            $this->json_return($re);

        }



    /**
     *
     * @api {post} /?action=login 用户登录
     * @apiDescription 用户登录
     * @apiGroup User
     * @apiName login
     * @apiParam {string} userid 账号
     * @apiParam {string} password 密码
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=login
     *
     * @apiSuccess {String} code 返回码，1成功，0失败
     * @apiSuccess {String} msg  错误信息
     */
    private function login(){
        $userid=$_POST['userid'];
        $password=$_POST['password'];

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


    /**
     *
     * @api {post} /?action=addWeixinInfo 微信信息添加
     * @apiDescription 添加微信信息到用户表
     * @apiGroup WEIXIN
     * @apiName addWeixinInfo
     * @apiParam {string} userid 用户名
     * @apiParam {string} openid openid
     * @apiParam {string} headimgurl 头像
     * @apiParam {string} nickname 昵称
     * @apiParam {string} sex 性别
     * @apiParam {string} country 国家
     * @apiParam {string} province 省
     * @apiParam {string} city 市
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=addWeixinInfo
     *
     * @apiSuccess {String} code 返回码，1成功，0失败
     * @apiSuccess {String} msg  错误信息
     */
    private function addWeixinInfo(){
        $conn=M();
        $userid=$_POST['userid'];

        if(!varIsAble($userid)){
            $re=array('code' => '0' ,'type' => '[userid]为必填字段' );
            $this->json_return($re);
        }


        $reback=$conn->query("select * from att_userinfo where userid='$userid'");
        if($reback[0]['headimgurl']!="null" && $reback[0]['headimgurl']!=""){
            $re=array('code' => '0' ,'type' => '已经存在头像，不需要更新' );
            $this->json_return($re);
        }
        else {
            $headimgurl=$_POST['headimgurl'];
            $nickname=$_POST['nickname'];
            $sex=$_POST['sex'];
            $country=$_POST['country'];
            $province=$_POST['province'];
            $city=$_POST['city'];
            $openid=$_POST['openid'];
            $re=$conn->execute("update att_userinfo set headimgurl='$headimgurl',nickname='$nickname',sex=1,country='$country',province='$province',city='$city',openid='$openid' where userid='$userid'");
            if($re>0){
                $re=array('code' => '1' ,'type' => '更新成功' );
                $this->json_return($re);
            }
            else {
                $re=array('code' => '0' ,'type' => '操作失败' );
                $this->json_return($re);
            }
        }
    }


    /**
     *
     * @api {post} /?action=tryLoginWeixin 登录微信授权
     * @apiDescription 如果已经绑定微信，则第二次直接跳转到个人中心页面
     * @apiGroup WEIXIN2
     * @apiName addWeixinInfo
     * @apiParam {string} openid openid
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=tryLoginWeixin
     *
     * @apiSuccess {String} code 返回码，1成功，0失败
     * @apiSuccess {String} msg  提示信息
     * @apiSuccess {String} userid  返回openid对应的账号
     */
    private function tryLoginWeixin(){
        $conn=M();
        $openid=$_POST['openid'];
        $reback=$conn->query("select * from att_userinfo where openid='$openid'");

        if(count($reback)>0){
            session_start();
            $re=array('code' => '1' ,'msg' => '已经绑定微信号' ,'userid' => $reback[0]['userid']);
            // 存储 session 数据
            $_SESSION['userid']=$reback[0]['userid'];
            $this->loginLog();



            $this->json_return($re);
        }
        else {
            $re=array('code' => '0' ,'msg' => '未绑定账号' );
            $this->json_return($re);
        }
    }



    /**
     *
     * @api {post} /?action=delWeixinInfo 重置att_userinfo微信信息
     * @apiDescription 数据库att_userinfo开关
     * @apiGroup Switch
     * @apiName addWeixinInfo
     * @apiParam {string} userid 用户名
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=delWeixinInfo
     *
     * @apiSuccess {String} code 返回码，1成功，0失败
     * @apiSuccess {String} msg  错误信息
     */
    private function delWeixinInfo(){
        $conn=M();
        $userid=$_POST['userid'];
        if(!varIsAble($userid)){
            $re=array('code' => '0' ,'type' => '[userid]为必填字段' );
            $this->json_return($re);
        }
        $re=$conn->execute("update att_userinfo set password='123456',headimgurl=null,nickname=null,sex=null,country=null,province=null,city=null,openid=null where userid='$userid';");
        if($re>0){
            $re=array('code' => '1' ,'type' => '重置成功' );
            $this->json_return($re);
        }
        else {
            $re=array('code' => '0' ,'type' => '重置失败，userid输入有误！' );
            $this->json_return($re);
        }
    }

    /**
     *
     * @api {post} /?action=getBookApplyList 购书申请审核列表
     * @apiDescription 获取购书申请审核的列表
     * @apiGroup Book
     * @apiName getBookApplyList
     * @apiParam {int} status 0：未审核，1：已审核，2：所有购书申请
     * @apiParam {int} page 页码数
     * @apiParam {int} size 每页数据长度
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=getBookApplyList
     *
     * @apiSuccess {int} total status选定状态的总条数
     * @apiSuccess {int} page 页码
     * @apiSuccess {int} size 分页大小
     * @apiSuccess {int} pagersize 总页数
     * @apiSuccess {int} count 当前页的数量，如最后一页的时候不一定达到size大小
     * @apiSuccess {json} r 返回详细信息
     * @apiSuccess {string} sql sql查询语句
     */
    private function getBookApplyList(){
         $conn=M();

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $size = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $status=$_GET['status'];

        // if(!varIsAble($page)){
        //     $re=array('code' => '0' ,'type' => '[page]为必填字段' );
        //     $this->json_return($re);
        // }
        // if(!varIsAble($size)){
        //     $re=array('code' => '0' ,'type' => '[size]为必填字段' );
        //     $this->json_return($re);
        // }
        // if(!varIsAble($status)){
        //     $re=array('code' => '0' ,'type' => '[status]为必填字段' );
        //     $this->json_return($re);
        // }
        // if(!($status=='0' || $status=='1' || $status=='2')){
        //     $re=array('code' => '0' ,'type' => '[status]为必填字段，status:0未审核,status:1已审核,status:2所有数据' );
        //     $this->json_return($re);
        // }

        $start=$size*($page-1);
        $sql="select top {$size} * from book_apply where id not in ( select top {$start} id from book_apply order by id ) and status='{$status}' order by checktime asc";
        
        $date=$conn->query($sql);


        if($status=='0' ||$status=='1'){
            $SQLforTotal="select count(*) as count from book_apply where status='{$status}'";
        }
        if($status=='2'){
            $SQLforTotal="select count(*) as count from book_apply";
        }
        $reback=$conn->query($SQLforTotal);
        $re['total']=$reback[0]['count'];
        $re['page']=$page;
        $re['size']=$size;
        $re['pagersize']=(int)ceil($re['total']/$size);
        $re['count']=count($date);
        $re['r']=$date;
        $re['sql']=$sql;



        // foreach ($re['r'] as $item) {
            // $item['name']=getInfoByUserid($item['userid']);
            // if($item['status']==0){
            //     $item['status']=='待审核';
            // }
        // }

        // if($type=='0'){
        //     $re=array();
        //     $data=$conn->query("select count(*) as count from book_apply where status='0'");
        //     $re['total']=$data[0]['count'];
        //     $re['re']=$conn->query("select * from book_apply where status='0' order by checktime asc");
        // }
        // if($type=='1'){
        //     $re=array();
        //     $data=$conn->query("select count(*) as count from book_apply where status='1'");
        //     $re['total']=$data[0]['count'];
        //     $re['re']=$conn->query("select * from book_apply where status='1' order by checktime asc");

        // }
        // if($type=='2'){
        //     $re=array();
        //     $data=$conn->query("select count(*) as count from book_apply where status='2' order by checktime asc");
        //     $re['total']=$data[0]['count'];
        //     $re['re']=$conn->query("select * from book_apply");
        // }

        // dump($re);
        // exit();
        $this->json_return($re['r']);
    }
    /*
        如何实现分页：http://www.cnblogs.com/Bulid-For-NET/archive/2012/12/16/2820097.html

        然后向里面插入大约1000条数据，进行分页测试
        假设页数是10，现在要拿出第5页的内容，查询语句如下：
        --10代表分页的大小

        select top 10 *
        from book_apply
        where id not in
        (
         --40是这么计算出来的：10*(5-1)
         select top 40 id from book_apply order by id
        )
        order by id

        原理：需要拿出数据库的第5页，就是40-50条记录。首先拿出数据库中的前40条记录的id值，然后再拿出剩余部分的前10条元素
    */
    private function test(){
        $conn=M();
        $size=3;
        $page=2;
        $start=$size*($page-1);
        $sql="
        select top {$size} *
        from book_apply
        where id not in ( select top {$start} id from book_apply order by id ) order by checktime asc";
        $re=$conn->query($sql);
        dump($re);
    }
    private function add_library(){
        // echo "add_library";

        $isbn13=$_POST['isbn13'];
        $intro=$_POST['intro'];
        $count=$_POST['count'];

        $isbnURL="https://api.douban.com/v2/book/isbn/:".$isbn13;

        $jsonData=getJSON($isbnURL);
        // echo $jsonData['publisher'];
        $bookinfo=json_decode($jsonData,true);


        $isbn10=$bookinfo['isbn10'];
        $name=$bookinfo['title'];
        $name_en=$bookinfo['origin_title'];
        $pic_url=$bookinfo['images']['large'];

        $author=$bookinfo['author'][0];
        $author_info=$bookinfo['author_intro'];
        $summary=$bookinfo['summary'];
        $catalog=$bookinfo['catalog'];
        $public_name=$bookinfo['publisher'];
        $public_date=$bookinfo['pubdate'];
        $pages_size=$bookinfo['pages'];
        $price=$bookinfo['price'];
        $douban_info_url=$bookinfo['alt'];


        if ($name_en=='') {
            $name_en="(>﹏<。)～呜呜呜……~暂无外文名";
        }
        
        if ($author_info=='') {
            $author_info="(>﹏<。)～呜呜呜……~暂无作者简介";
        }

        if ($summary=='') {
            $summary="(>﹏<。)～呜呜呜……~暂无概要";
        }
        if ($catalog=='') {
            $catalog="(>﹏<。)～呜呜呜……~暂无目录";
        }


        $conn=M();
        // echo "insert into book_library(ISBN13,ISBN10,time,status,add_intro) values('{$isbn13}','{$isbn10}',getdate(),'1','{$intro}');";
        // exit();

        $conn->execute("insert into book_library(ISBN13,ISBN10,time,status,add_intro) values('{$isbn13}','{$isbn10}',getdate(),'1','{$intro}');");

        $re=$conn->query("select count(*) as count from book_base where isbn13='{$isbn13}' or isbn10='{$isbn10}';");


        // book_base 表中不存在该书的信息则 insert插入
        if($re[0]['count']==0){


            $result=$conn->execute("insert into book_base(ISBN13,ISBN10,name,name_en,pic_url,author,author_info,summary,catalog,public_name,public_date,pages_size,price,douban_info_url,checktime,inventory,inventory_r) values('{$isbn13}','{$isbn10}','{$name}','{$name_en}','{$pic_url}','{$author}','{$author_info}','{$summary}','{$catalog}','{$public_name}','{$public_date}','{$pages_size}','{$price}','{$douban_info_url}',getdate(),1,1)");
            if($result>0){
                // echo '新增成功';
                $data=$conn->query("select count(*) as count from book_library");
                $re=array('code' => '1' ,'msg' => '新增成功' ,'book_number' => $data[0]['count'] );
                echo json_encode($re);
                // write_login_session();
                return;
            }
            else {

                $re=array('code' => '0' ,'msg' => '新增失败' );
                echo json_encode($re);
                // write_login_session();
                return;
            }
        }
        // book_base 表中存在该条记录  则更新 [库存量]和[可借库存量]字段 +1
        else {
            // echo '已经存在';
            $result=$conn->execute("update book_base set inventory=inventory+1,inventory_r=inventory_r+1 where isbn13='{$isbn13}'");
            if($result>0){
                // echo '库存更新成功+1';

                $data=$conn->query("select count(*) as count from book_library");
                $re=array('code' => '2' ,'msg' => '库存更新成功' ,'book_number' => $data[0]['count'] );
                echo json_encode($re);
                // write_login_session();
                return;
            }
            else {
                $re=array('code' => '-1' ,'msg' => '新增失败' );
                echo json_encode($re);
                // write_login_session();
                return;
            }
        }
    }

     /**
     *
     * @api {post} /?action=getBookinfo
     * @apiDescription 获取图书信息
     * @apiGroup User
     * @apiName getBookinfo
     * @apiParam {String} book_id 图书数据库id编号
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=getBookinfo
     *
     * @apiSuccess {JSON} JsonStr 返回JSON数据
     */
     private function getBookinfo(){
        $book_id=$_POST['book_id'];
        $User=M();
        $re=$User->query("select * from book_base where id='{$book_id}'");
        echo json_encode($re[0]);
        return;
    }



    /**
     *
     * @api {post} /?action=book_application 购书申请
     * @apiDescription 普通用户提交自己的购书申请
     * @apiGroup Book
     * @apiName book_application
     * @apiParam {string} isbn 图书13位ISBN
     * @apiParam {string} bookurl 购买图书参考链接
     * @apiParam {string} purchase_reason 购书申请理由
     * @apiParam {string} userid 用户名
     * @apiParam {string} [btnswitch] 是否要短信通知
     * @apiParam {string} [mobile] 通知手机号
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/?action=book_application
     *
     * @apiSuccess {int} code 1-成功，0-失败
     * @apiSuccess {string} msg 返回提示信息
     */
    private function book_application(){
        $info =array();
        $info[]=$isbn=$_POST['isbn'];
        $info[]=$bookurl=$_POST['bookurl'];
        $info[]=$mobile=$_POST['mobile'];
        $info[]=$purchase_reason=$_POST['purchase_reason'];
        $info[]=$userid=$_POST['userid'];
        $info[]=$btnswitch=$_POST['btnswitch'];
        //获取申请人姓名
        $uname=getInfoByUserid($userid)['name'];


        //获取书名
        $title=getTitleByIsbn($isbn);
        
        if($btnswitch) $btnswitch=1;
        else $btnswitch=0;

        if(!varIsAble($isbn)){
            $re=array('code' => '0' ,'msg' => '[isbn]为必填字段' );
            echo json_encode($re);
            return;
        }
        if(!varIsAble($bookurl)){
            $re=array('code' => '0' ,'msg' => '[bookurl]为必填字段' );
            echo json_encode($re);
            return;
        }
        if(!varIsAble($purchase_reason)){
            $re=array('code' => '0' ,'msg' => '[purchase_reason]为必填字段' );
            echo json_encode($re);
            return;
        }
        if(!varIsAble($userid)){
            $re=array('code' => '0' ,'msg' => '[userid]为必填字段' );
            echo json_encode($re);
            return;
        }
        if(!isbnIsValid($isbn)){
            $re=array('code' => '-1' ,'msg' => 'ISBN无效' );
            echo json_encode($re);
            return;
        }

        $conn=M();

        // echo "insert into book_apply(isbn,bookurl,mobile,purchase_reason,userid,checktime,isconform) values('{$isbn}','{$bookurl}','{$mobile}','{$purchase_reason}','{$userid}',getdate(),$btnswitch)";
        // exit();


        $re=$conn->execute("insert into book_apply(isbn,bookurl,mobile,purchase_reason,userid,checktime,isconform,title,uname) values('{$isbn}','{$bookurl}','{$mobile}','{$purchase_reason}','{$userid}',getdate(),$btnswitch,'{$title}','{$uname}')");
        if($re>0){
            $re=array('code' => '1' ,'msg' => '申请成功' );
            echo json_encode($re);
            return;
        }
        else {
            $re=array('code' => '0' ,'msg' => '申请失败' );
            echo json_encode($re);
            return;
        }

        return;
    }

    /**
     * 列出User控制器操作方法的URL
     */
    private function listActionsUrl()
    {
        echo "当前URL模式为：".C('URL_MODEL');
        echo "<hr>";

        echo "User控制器index操作方法的URL为：<a href=\"".U('Home/User/index')."\">".U('Home/User/index')."</a>";
        echo "<hr>";

        echo "User控制器edit操作方法的URL为：<a href=\"".U('Home/User/edit')."\">".U('Home/User/edit')."</a>";
        echo "<hr>";

        echo "User控制器login操作方法的URL为：<a href=\"".U('Home/User/login')."\">".U('Home/User/login')."</a>";
        echo "<hr>";
    }



    /**
     * index前置操作
     */
    // public function _before_index() {
    //     echo "index.before</br>";
    // }

    /**
     * index后置操作
     */
    // public function _after_index() {
    //     echo "index.after</br>";
    // }

    /**
     * 操作方法后缀
     */
    // public function listAction()
    // {
    //  echo "list";
    // }
    private function json_return($arr){
        echo json_encode($arr);
        exit;
    }

    private function useridIsValid($userid){
        $conn=M();
        $re=$conn->query("select count(*) as count from att_userinfo where userid='{$userid}'");
        if($re[0]['count']==1){
            return 1;
        }
        else {
            return 0;
        }
    }



}



/**
 * 获取接口json格式的数据
 * @param url 接口地址
 */
function getJson($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22");
    curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function getTitleByIsbn($isbn){
    $isbnURL="https://api.douban.com/v2/book/isbn/:".$isbn;
    $jsonData=getJSON($isbnURL);
    // echo $jsonData['publisher'];
    $bookinfo=json_decode($jsonData,true);

    // if($isbn==$bookinfo['isbn10'] || $isbn==$bookinfo['isbn13']){
    //     return true;
    // }
    // else {
    //     return false;
    // }
    return $bookinfo['title'];
}




function isbnIsValid($isbn){

    $isbnURL="https://api.douban.com/v2/book/isbn/:".$isbn;

    $jsonData=getJSON($isbnURL);
    // echo $jsonData['publisher'];
    $bookinfo=json_decode($jsonData,true);

    if($isbn==$bookinfo['isbn10'] || $isbn==$bookinfo['isbn13']){
        return true;
    }
    else {
        return false;
    }

}


//判断 get && post值是有效的
function varIsAble(&$var){
    if(!isset($var)||$var==''){
        return 0;
    }
    else {
        return 1;
    }
}

//判断 string字符串是不是时间类型的
function strIsTime($time){
    $istime=preg_match("/^[0-9]{4}(\-|\/)[0-9]{1,2}(\\1)[0-9]{1,2}(|\s+[0-9]{1,2}(|:[0-9]{1,2}(|:[0-9]{1,2})))$/",$time);
    if($istime){
        return 1;
    }
    else {
        return 0;
    }
}


//获取string字符串中的数字
function strFindNum($str=''){
    $str=trim($str);
    if(empty($str)){return '';}
    $result='';
    for($i=0;$i<strlen($str);$i++){
        if(is_numeric($str[$i])){
            $result.=$str[$i];
        }
    }
    return $result;
}


//获取用户信息方法
function getInfoByUserid($userid)
{
        $conn=M();
        $re=$conn->query("SELECT att_userinfo.nickname,att_userinfo.sex,att_userinfo.country,att_userinfo.province,att_userinfo.city,att_userinfo.headimgurl,att_userinfo.cardid, att_userinfo.name, DEPARTMENTS.DEPTNAME AS deptname, att_userinfo.password, att_userinfo.userid FROM att_userinfo INNER JOIN DEPARTMENTS ON att_userinfo.departid = DEPARTMENTS.DEPTID where att_userinfo.userid='{$userid}'");
        return $re[0];
}
