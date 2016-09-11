<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller
{
    
    /**
     * index操作方法
     */
    public function index() {
        switch ($_GET['action']) {
            //重置att_check表数据
            case 'att_check_in':
                $this->att_check_in();
                break;
            case 'privilege_add'://特权add
                $this->privilege_add();
                break;
            case 'privilege_list'://特权list
                $this->privilege_list();
                break;
            case 'privilege_trans'://特权修改
                $this->privilege_trans();
                break;
            case 'privilege_del'://特权删除
                $this->privilege_del();
                break;
            case 'user_pri_list'://用户特权
                $this->user_pri_list();
                break;
            case 'user_pri_add'://用户特权add
                $this->user_pri_add();
                break;
            case 'user_pri_del'://用户特权del
                $this->user_pri_del();
                break;
            case 'book_index'://书目录查询
                $this->book_index();
                break;
            case 'bor_rank'://借阅排行
                $this->bor_rank();
                break;
            case 'bor_book':
                $this->bor_book();
                break;
            case 'book_borrowed':
                $this->book_borrowed();
                break;
            case 'book_unborrowed':
                $this->book_unborrowed();
                break;
            case 'book_info':
                $this->book_info();
                break;
            case 'book_bro_ret':
                $this->book_bro_ret();
                break;
            case 'book_borrow_er':
                $this->book_borrow_er();
            
            case 'bf_list'://早餐
                $this->bf_list();
                break;
            case 'pic_bf'://选择早餐
                $this->pic_bf();
                break;
            default:
                // code...
            echo '参数错误';
            break;
        }
    }
    
    /*
     *修改密码
     */
    public function modifyPw(){
        $ret=array();
        $un=$_POST["username"];
        $oldpw=$_POST["oldpw"];
        $pw=$_POST["password"];

        $User=M();
        $data=$User->query("SELECT dbo.att_userinfo.password FROM dbo.att_userinfo WHERE dbo.att_userinfo.userid = '$un' ");
        if(!isset($data)||$data==array()){
            $ret=array("code"=>0,"msg"=>"帐号不存在");
            $this->json_return($ret);
        }
        
        if($oldpw==$data[0]['password']){
            $User->execute("update att_userinfo set password='".$pw."' where userid='".$un."' ");
            $ret=array(
                        "code"=>1,
                        "msg"=>"修改成功"
                    );
            $this->json_return($ret);
        }else{
            $ret=array(
                        "code"=>0,
                        "msg"=>"密码错误"
                );
            $this->json_return($ret);
        }
    }

    /**
     * booklist
     */
    public function booklist(){
        $start=intval($_REQUEST['start']?$_REQUEST['start']:0);
        $limit=intval($_REQUEST['limit']?$_REQUEST['limit']:20);

        $book_id=intval($_REQUEST['book_id']);
        if(!empty($book_id)){
            $data=M()->query("SELECT * FROM dbo.book_base WHERE id=$book_id");
            $ret=array(
                "code"=>1,
                "msg"=>success,
                "book_info"=>$data
            );
            $this->json_return($ret);
        }

        $booklist=M();
        $tot=M()->query("select count(0) from dbo.book_base");
        $tot=$tot[0][""];
        $data=$booklist->query("SELECT TOP $limit * FROM dbo.book_base WHERE 1=1 and id not in (select  TOP $start id FROM dbo.book_base)");
        $ret=array();
        $ret=array(
            "code"=>1,
            "msg"=>"success",
            "tot"=>$tot,
            "bList"=>$data
        );

        $this->json_return($ret);
    }
    /**
     * 
     * @api {post} /index.php/Home/User/?action=book_index 书目录查询
     * @apiDescription 书目录查询
     * @apiGroup BOOK
     * @apiName book_index
     * @apiParam {string} ISBN13 
     * @apiParam {string} ISBN10 
     * @apiParam {string} name              书名
     * @apiParam {string} name_en           英文名
     * @apiParam {string} author            作者
     * @apiParam {int} inventory_max        库存:min=<x<max
     * @apiParam {int} inventory_min 
     * @apiParam {int} inventory_r_max      可借
     * @apiParam {int} inventory_r_min 
     * @apiParam {int} bookshelf_max        书架号
     * @apiParam {int} bookshelf_min 
     * @apiParam {int} checktime_max        入库时间
     * @apiParam {int} checktime_max 
     * @apiParam {int} pages_size_min       页数
     * @apiParam {int} pages_size_min 
     * @apiParam {string} public_date       出版时间
     * @apiParam {string} public_date  
     * @apiParam {string} order             排序
     * @apiParam {int} seq                  排序方式0：倒序；1：正序
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://www.ifrank.loan/index.php/Home/User/?action=book_index
     *
     * @apiSuccess {json} data json数组对象
     */
    public function book_index(){
        $ret=array("r"=>0,"msg"=>"","date"=>array());
        $REQ=$_REQUEST;

        $WHERE["ISBN13"]=getReq($REQ,"ISBN13",0);
        $WHERE["ISBN10"]=getReq($REQ,"ISBN10",0);
        $WHERE["name"]=getReq($REQ,"name","");
        $WHERE["name_en"]=getReq($REQ,"name_en","");
        $WHERE["author"]=getReq($REQ,"author","");

        $WHERE_max['bookshelf']=getReq($REQ,"bookshelf_max",0);
        $WHERE_min['bookshelf']=getReq($REQ,"bookshelf_min",0);
        $WHERE_max['inventory']=getReq($REQ,"inventory_max",0);
        $WHERE_min['inventory']=getReq($REQ,"inventory_min",0);
        $WHERE_max['inventory_r']=getReq($REQ,"inventory_r_max",0);
        $WHERE_min['inventory_r']=getReq($REQ,"inventory_r_min",0);
        $WHERE_max['checktime']=getReq($REQ,"checktime_max",date("Y-m-d",time()));
        $WHERE_min['checktime']=getReq($REQ,"checktime_min",0);
        $WHERE_min['pages_size']=getReq($REQ,"pages_size_min",0);
        $WHERE_max['pages_size']=getReq($REQ,"pages_size_max",0);
        $WHERE_min['public_date']=getReq($REQ,"public_date_min",0);
        $WHERE_max['public_date']=getReq($REQ,"public_date_max",0);

        $ORDER=getReq($REQ,"order","");
        $SEQ=getReq($REQ,"seq",0);
        $lib_c=$this->colum_name("book_base");
        if(!in_array($ORDER,$lib_c)){
            $ORDER="checktime";
        }


        $sql="SELECT id,name FROM book_base ";
        $where=" WHERE 1=1 ";
        foreach ($WHERE as $key => $value) {
            if(!empty($value)&&is_numeric($value))
            {
                $where.=" and $key=$value ";
            }else if(!empty($value)){
                $where.=" and $key='".$value."' ";
            }
        }

        foreach ($WHERE_max as $key => $value) {
            if(!empty($value)&&is_numeric($value))
            {
                $where.=" and $key<$value ";
            }else if(!empty($value)){
                $where.=" and $key<'".$value."' ";
            }
        }

        foreach ($WHERE_min as $key => $value) {
            if(!empty($value)&&is_numeric($value))
            {
                $where.=" and $key>=$value ";
            }else if(!empty($value)){
                $where.=" and $key>='".$value."' ";
            }
        }
        if($ORDER){
            $order=" order by $ORDER ";
        }
        if($SEQ){
            $order.=" desc ";
        }else{
            $order.=" asc ";
        }
        $SQL=$sql.$where.$order;
        //var_dump($SQL,$sql,$where,$order);
        $result=M()->query($sql.$where.$order);
        if($result){
            $ret=array(
                "code"=>1,
                "msg"=>"success",
                "data"=>$result
            );
            $this->json_return($ret);
        }else{
            $ret=array(
                "code"=>0,
                "msg"=>"false",
                "data"=>array()
            );
            $this->json_return($ret);
        }
    }


    /**
     * 
     * @api {post} /index.php/Home/User/?action=bor_rank 借书排行
     * @apiDescription 借书排行
     * @apiGroup BOOK
     * @apiName bor_rank
     * 
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://www.ifrank.loan/index.php/Home/User/?action=bor_rank
     *
     * @apiSuccess {int} rank 排名
     * @apiSuccess {int} cardid 工号
     * @apiSuccess {string} name 姓名
     * @apiSuccess {int} num 借阅量
     */
    public function bor_rank(){
        $sql="SELECT cardid,dbo.f_uname_by_cardid(cardid) as name,count(0) as num FROM [dbo].[book_borrow] group by cardid order by num desc";
        $result=M()->query($sql);
        $i=1;
        foreach ($result as $key => $value) {
            $result[$key]["rank"]=$i;
            $i++;
        }

        $this->json_return($result);
    }

    public function bor_book(){
        $REQ=$_REQUEST;
    }
    /**
     * 
     * @api {post} /index.php/Home/User/?action=book_library 书本查询
     * @apiDescription 书本查询
     * @apiGroup BOOK
     * @apiName book_library
     * @apiParam {type} param 
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://www.ifrank.loan/index.php/Home/User/?action=book_library
     *
     * @apiSuccess {json} data json数组对象
     */
    public function book_library(){
        $REQ=$_REQUEST;
        $ret=array("r"=>0,"msg"=>false);
        $WHERE["id"]=getReq($REQ,"id",0);
        $WHERE["book_id"]=getReq($REQ,"book_id",0);
        $WHERE_max["time"]=getReq($REQ,"time_max",date("Y-m-d H:i:s",time()));
        $WHERE_min["time"]=getReq($REQ,"time_min","");
        $WHERE["status"]=getReq($REQ,"status",1);//status:1、可借。2、已借
        $WHERE["cardid"]=getReq($REQ,"cardid",0);
        $WHERE["ISBN13"]=getReq($REQ,"isbn13","");
        $WHERE["ISBN10"]=getReq($REQ,"isbn10","");

        foreach ($WHERE as $key => $value) {
            if(!empty($value)&&is_numeric($value))
            {
                $where.=" and $key=$value ";
            }else if(!empty($value)){
                $where.=" and $key='".$value."' ";
            }
        }

        foreach ($WHERE_max as $key => $value) {
            if(!empty($value)&&is_numeric($value))
            {
                $where.=" and $key<$value ";
            }else if(!empty($value)){
                $where.=" and $key<'".$value."' ";
            }
        }

        foreach ($WHERE_min as $key => $value) {
            if(!empty($value)&&is_numeric($value))
            {
                $where.=" and $key>=$value ";
            }else if(!empty($value)){
                $where.=" and $key>='".$value."' ";
            }
        }

        $sql="SELECT * FROM book_library WHERE ";

        $result=M()->query($sql.$where);
        if($result){
            $ret=array("r"=>1,"msg"=>success,"data"=>$result);
        }else{
            $ret=array("r"=>0,"msg"=>false,"data"=>$result);
        }

    }
    /**
     * @cjn
     * @api {post} /index.php/Home/User/?action=book_borrowed 已借
     * @apiDescription 已借
     * @apiGroup BOOK
     * @apiName book_borrowed
     * @apiParam {type} param 
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://www.ifrank.loan/index.php/Home/User/?action=book_borrowed
     *
     * @apiSuccess {json} data json数组对象
     */
    public function book_borrowed(){
        $sql="select re.*,dbo.f_bname_by_isbn13(re.ISBN13) as book_name
                from 
                (SELECT count(0) as num,ISBN13,max(ISBN10) as ISBN10,max(status) AS status FROM dbo.book_library WHERE status=2 group by ISBN13) as re";
        $result=M()->query($sql);
        if($result){
            $ret=array("r"=>1,"msg"=>success,"data"=>$result);
        }else{
            $ret=array("r"=>0,"msg"=>false,"data"=>$result);
        }
        $this->json_return($ret);
    }
    //new 已借
    public function book_borrow_er(){
        $sql="SELECT dbo.f_bname_by_isbn13(bli.ISBN13) as book_name,dbo.f_uname_by_cardid(bbo.cardid) as username,bli.*,bbo.*
FROM dbo.book_library bli
left join dbo.book_borrow bbo
on bli.id=bbo.book_id
WHERE bli.status=2
and bbo.do_type=1";
        $result=M()->query($sql);
        if($result){
            $ret=array("r"=>1,"msg"=>success,"data"=>$result);
        }else{
            $ret=array("r"=>0,"msg"=>false,"data"=>$result);
        }
        $this->json_return($ret);
    }
    public function book_unborrow_er(){
        $sql="SELECT dbo.f_bname_by_isbn13(bli.ISBN13) as book_name,dbo.f_uname_by_cardid(bbo.cardid) as username,bli.*,bbo.*
FROM dbo.book_library bli
left join dbo.book_borrow bbo
on bli.id=bbo.book_id
WHERE bli.status=1
and bbo.do_type=1";
        $result=M()->query($sql);
        if($result){
            $ret=array("r"=>1,"msg"=>success,"data"=>$result);
        }else{
            $ret=array("r"=>0,"msg"=>false,"data"=>$result);
        }
        $this->json_return($ret);
    }

    /**
     * @cjn
     * @api {post} /index.php/Home/User/?action=book_unborrowed 未借
     * @apiDescription 未借
     * @apiGroup BOOK
     * @apiName book_unborrowed
     * @apiParam {type} param 
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://www.ifrank.loan/index.php/Home/User/?action=book_unborrowed
     *
     * @apiSuccess {json} data json数组对象
     */
    public function book_unborrowed(){
        $sql="SELECT count(0) as num,ISBN13,max(ISBN10) as ISBN10,max(status) AS status  FROM book_library WHERE status=1 group by ISBN13";
        $result=M()->query($sql);
        if($result){
            $ret=array("r"=>1,"msg"=>success,"data"=>$result);
        }else{
            $ret=array("r"=>0,"msg"=>false,"data"=>$result);
        }
        $this->json_return($ret);
    }
    /**
     *
     * @api {post} /index.php/Home/User/?action=book_info 书籍信息
     * @apiDescription 书籍信息
     * @apiGroup BOOK
     * @apiName book_info
     * @apiParam {type} param 
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://www.ifrank.loan/index.php/Home/User/?action=book_info
     *
     * @apiSuccess {json} data json数组对象
     */
    public function book_info(){
        $REQ=$_REQUEST;
        $book_library_id=getReq($REQ,"book_library_id",0);
        $sql="SELECT * FROM book_library bl 
                left join book_base bb on bl.ISBN13=bb.ISBN13 
                WHERE bl.id=$book_library_id";
        $result=M()->query($sql);
        if($result){
            $ret=array("r"=>1,"msg"=>success,"data"=>$result);
        }else{
            $ret=array("r"=>0,"msg"=>false,"data"=>$result);
        }
        $this->json_return($ret);
    }

/*    public function book_info(){
        $ret=array("r"=>0,"msg"=>"","date"=>array());
        $REQ=$_REQUEST;
        $WHERE["ISBN13"]=getReq($REQ,"ISBN13",0);
        $WHERE["ISBN10"]=getReq($REQ,"ISBN10",0);
        $WHERE["name"]=getReq($REQ,"name","");
        $WHERE["name_en"]=getReq($REQ,"name_en","");
        $WHERE["author"]=getReq($REQ,"author","");

        $sql="SELECT * FROM book_base ";
        $where="";

    }*/

    /**
     * 
     * @api {post} /index.php/Home/User/?action=book_bro_ret 借书还书
     * @apiDescription 借书还书
     * @apiGroup ATTprivilege
     * @apiName book_bro_ret
     * @apiParam {type} param 
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://www.ifrank.loan/index.php/Home/User/?action=book_bro_ret
     *
     * @apiSuccess {json} data json数组对象
     */
    public function book_bro_ret(){
        $ret=array();
        $REQ=$_REQUEST;
        $book_id=getReq($REQ,"book_id",0);
        $cardid=getReq($REQ,"cardid",0);
        $validity=getReq($REQ,"validity",0);
        $do_type=getReq($REQ,"do_type",1);
        if(empty($book_id)&empty($cardid)&empty($validity)&empty($do_type)){
            $ret=array("r"=>0,"msg"=>"参数错误");
            $this->json_return($ret);
        }

        switch ($do_type) {
            case 1:
                $operation="借书操作";
                break;
            
            default:
                $operation="还书操作";
                break;
        }

        $time=date("Y-m-d H:i:s",time());
        $sql="INSERT into book_borrow (book_id,operation,[time],cardid,validity,do_type) values ($book_id,'".$operation."','".$time."',$cardid,$validity,$do_type)";
        //var_dump($sql);
        $result=M()->execute($sql);
        if($result){
            $ret=array("r"=>1,"msg"=>success,"data"=>$result);
        }else{
            $ret=array("r"=>0,"msg"=>false,"data"=>$result);
        }
        $this->json_return($ret);
    }

    public function bookdel(){
        $ret=array(
            "code"=>0,
            "msg"=>"false"
        );
        if(empty($_REQUEST['book_id'])){
            $ret['msg']="需要book_id";
            $this->json_return($ret);
        }
        $book_id=intval($_REQUEST['book_id']);

        $r=M()->execute("DELETE FROM dbo.book_base WHERE id=$book_id");
        if($r){
            $ret=array(
                "code"=>1,
                "msg"=>"success"
            );
            $this->json_return($ret);
        }else{
            $ret=array(
                "code"=>0,
                "msg"=>"false"
            );
            $this->json_return($ret);
        }
    }

    /**
     * book edit
     */
    public function edit() {
        $lib_c=$this->colum_name("book_base");
        $bas_c=$this->colum_name("book_library");

        // echo "add_library";
        $REQ=$_REQUEST;
        $book_base=getReq($REQ,"isbn13","");

        $basarr["isbn13"]=$_POST['isbn13'];
        $basarr["intro"]=$_POST['intro'];
        $basarr["count"]=$_POST['count'];


        foreach ($lib_c as $key => $value) {
            $param=getReq($REQ,$value,"");
            if(!empty($param)){
                $bliarr[$value][]=$parma;
            }
        }


        foreach ($lib_c as $key => $value) {
            $l_c_list[]=$lib_c[$key]['name'];
        }

        foreach ($bas_c as $key => $value) {
            $b_c_list[]=$bas_c[$key]['name'];
        }

        dump($l_c_list);
        dump($b_c_list);exit;

        $sql_l="UPDATE book_base set ";

        foreach ($bliarr as $key => $value) {
            if(in_array($key,$l_c_list)){
                $sql_l.=" `$key`=$value,";
            }
        }

        $sql_l=substr($sql,0,-1);
        $sql_l.=" WHERE id=".$bliarr['id'];
        dump($sql_l);exit;


        $conn=M();
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


    public function colum_name($table){
        if(!empty($table)){
            $table_name=$table;
        }elseif(!empty($_REQUEST['table'])){
            $table_name=$_REQUEST['table'];
        }else{
            $table_name="book_base";
        }
        
        $sql="select name from syscolumns where id = object_id('".$table_name."')";
        $columlist=M()->query($sql);
        if(!empty($table)){
            return $columlist;
        }else{
            $this->json_return($columlist);
        }
    }

    public function sqleach($res){
        foreach ($res as $key => $value) {
            $ret[]="";
        }
    }

    public function test(){
        $now=time();
        $nowF=date("Y-m-d H:i:s",$now);
        $nowYmd=strtotime(date("Y-m-d",$now));
        $timeArr=array();
        for($i=0;$i<7;$i++){
            $timeArr[]=($now+$i*3600-$nowYmd)*1000;
        }
        $this->json_return(array("tstamp"=>$timeArr));
        
    }


    
    /**
     *
     * @api {post} /index.php/Home/User/?action=privilege_list 特权list
     * @apiDescription 特权list
     * @apiGroup ATT_privilege
     * @apiName privilege_list
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/index.php/Home/User/?action=privilege_list
     *
     * @apiSuccess {json} data json数组对象
     * @apiSuccess {int} id
     * @apiSuccess {int} type 特权类型
     * @apiSuccess {int} name 特权名称
     * @apiSuccess {int} validity 特权有效期（天）
     * @apiSuccess {int} msg 特权说明
     */
    public function privilege_list() {
        $REQ=$_REQUEST;
        $id=getReq($REQ,"id",0);

        $sql="SELECT * FROM att_privilege";
        $where=" WHERE 1=1 ";
        if($id){
            $where.=" and id=$id ";
        }
        $result=M()->query($sql.$where);
        $this->json_return($result);
    }

    public function pic_bf(){
        $ret=array();
        $REQ=$_REQUEST;
        $bf_code=getReq($REQ,"bf_code","");
        array("","","","");

        $sql="";
    }

    public function bf_list(){
        $ret=array();
        $REQ=$_REQUEST;
        $WHERE['cardid']=getReq($REQ,"cardid",0);
        $sql="SELECT * from att_pri_bf ";
        $where=" WHERE 1=1 ";

        if($WHERE['cardid']&&is_numeric($WHERE['cardid'])){
            $where.=" and cardid=".$WHERE['cardid'];
        }

        $result=M()->query($sql);
        if($result){
            $ret=array("r"=>1,"msg"=>success,"data"=>$result);
        }else{
            $ret=array("r"=>0,"msg"=>false,"data"=>$result);
        }
        $this->json_return($ret);
    }
    /**
     *
     * @api {post} /index.php/Home/User/?action=privilege_add 特权add
     * @apiDescription 特权add
     * @apiGroup ATT_privilege
     * @apiName privilege_add
     * @apiParam {int} type 特权类型 not null
     * @apiParam {string} name 特权名称 not null
     * @apiParam {int} validity 特权有效期（天） not null
     * @apiParam {string} msg 特权说明
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/index.php/Home/User/?action=privilege_add&t_start=2016-08-03&t_stop=2016-08-03
     *
     * @apiSuccess {int} r success:1,fail:0
     * @apiSuccess {string} msg 
     * 
     */
    public function privilege_add() {
        $ret=array("r"=>0,"msg"=>false);
        $REQ=$_REQUEST;
        $type=getReq($REQ,"type","");
        $name=getReq($REQ,"name","");
        $validity=getReq($REQ,"validity","");
        $msg=getReq($REQ,"msg","");

        if(empty($type)||empty($name)||empty($validity)||empty($msg)){
            $ret["msg"]="type、name、validity、msg不能为空";
            $this->json_return($ret);
        }
        if(!is_numeric($type)){
            $ret["msg"]="type必须为数字";
            $this->json_return($ret);
        }
        if(!is_numeric($validity)){
            $ret["msg"]="validity必须为数字";
            $this->json_return($ret);
        }


        $sql="INSERT INTO att_privilege (type,name,validity,msg) values (".$type.",'".$name."',".$validity.",'".$msg."')";

        $res=M()->execute($sql);
        if($res){
            $ret["r"]=1;
            $ret["msg"]="success";
            $this->json_return($ret);
        }else{
            $ret["msg"]="添加失败";
            $this->json_return($ret);
        }
    }
    /**
     *
     * @api {post} /index.php/Home/User/?action=privilege_trans 特权修改
     * @apiDescription 特权修改
     * @apiGroup ATT_privilege
     * @apiName privilege_trans
     * @apiParam {int} id 
     * @apiParam {int} type 
     * @apiParam {string} name 
     * @apiParam {int} validity 
     * @apiParam {string} msg 
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://www.ifrank.loan/index.php/Home/User/?action=privilege_trans
     *
     * @apiSuccess {json} data json数组对象
     */
    public function privilege_trans() {
        $ret=array("r"=>0,"msg"=>false);
        $REQ=$_REQUEST;
        $id=getReq($REQ,"id","");
        $type=getReq($REQ,"type","");
        $name=getReq($REq,"name","");
        $validity=getReq($REQ,"validity","");
        $msg=getReq($REQ,"msg","");
        if(empty($id)||empty($type)||empty($name)||empty($validity)||empty($msg)){
            $ret["msg"]="type、name、validity、msg不能为空";
            $this->json_return($ret);
        }
        if(!is_numeric($id)){
            $ret["msg"]="id必须为数字";
            $this->json_return($ret);
        }
        if(!is_numeric($type)){
            $ret["msg"]="type必须为数字";
            $this->json_return($ret);
        }
        if(!is_numeric($validity)){
            $ret["msg"]="validity必须为数字";
            $this->json_return($ret);
        }

        $sql="UPDATE att_privilege set type=".$type.",name='".$name."',validity=".$validity.",$msg='".$msg."' WHERE id=".$id." ";
        $res=M()->execute($sql);
        if($res){
            $ret["r"]=1;
            $ret["msg"]="success";
            $this->json_return($ret);
        }else{
            $ret["msg"]="修改失败";
            $this->json_return($ret);
        }
    }
    /**
     *
     * @api {post} /index.php/Home/User/?action=privilege_del 特权删除
     * @apiDescription 特权删除
     * @apiGroup ATT_privilege
     * @apiName privilege_del
     * @apiParam {int} id
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://www.ifrank.loan/index.php/Home/User/?action=privilege_del
     *
     * @apiSuccess {json} data json数组对象
     */
    public function privilege_del() {
        $ret=array("r"=>0,"msg"=>false);
        $REQ=$_REQUEST;
        $id=getReq($REQ,"id","");
        if(empty($id)){
            $ret["msg"]="id不能为空";
            $this->json_return($ret);
        }
        if(!is_numeric($id)){
            $ret["msg"]="id必须为数字";
            $this->json_return($ret);
        }

        $sql="DELETE FROM att_privilege WHERE id=$id";
        $res=M()->execute($sql);
        if($res){
            $ret=array("r"=>1,"msg"=>"success");
            $this->json_return($ret);
        }else{
            $ret["msg"]="删除失败";
            $this->json_return($ret);
        }


    }
    /**
     *
     * @api {post} /index.php/Home/User/?action=user_pri_list 用户特权
     * @apiDescription 用户特权
     * @apiGroup ATT_privilege
     * @apiName user_pri_list
     * @apiParam {int}          start            默认0
     * @apiParam {int}          limit            默认20
     * @apiParam {int}          userid           用户名查询
     * @apiParam {date}         time_add_start   特权获得时间
     * @apiParam {date}         time_add_stop    
     * @apiParam {string}       name             特权名
     * @apiParam {int}          validity         有效期
     * @apiParam {int}          status           特权状态1：可用；2：过期
     * @apiParam {string}       order            排序字段
     * @apiParam {int}          seq              排序方式
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://www.ifrank.loan/index.php/Home/User/?action=user_pri_list
     *
     * @apiSuccess {json} data json数组对象
     */
    public function user_pri_list() {
        $ret=array("tot"=>0,"start"=>0,"limit"=>20,"data"=>array());
        $REQ=$_REQUEST;
        $start=getReq($REQ,"start",0);
        $limit=getReq($REQ,"limit",20);
        $WHERE["userid"]=getReq($REQ,"userid",0);
        $timestart["time_add_start"]=getReq($REQ,"time_add_start",strtotime("2016-07-01"));
        $timestop["time_add_stop"]=getReq($REQ,"time_add_stop",time());
        $WHERE["name"]=getReq($REQ,"name","");
        $WHERE["validity"]=getReq($REQ,"validity","");
        $WHERE["status"]=getReq($REQ,"status","");
        $oS=getReq($REQ,"order","");
        $seq=getReq($REQ,"seq",0);
        if($oS!="userid"&&$oS!="time_add"&&$oS!="name"&&$oS!="validity"){
            $oS="time_add";
        }



        $sql="SELECT * FROM att_privilege_u ";
        $where=" WHERE 1=1 ";
        foreach ($WHERE as $key => $value) {
            if(!empty($value)&&is_numeric($value))
            {
                $where.=" and $key=$value ";
            }else if(!empty($value)){
                if($key="userid"){
                    $where.=" and cardid=dbo.f_cardid_by_userid('".$value."')";
                }else{
                    $where.=" and $key='".$value."' ";
                }
            }
        }
        $where.=" and time_add>'".date("Y-m-d",$timestart["time_add_start"])."' and time_add < '".date("Y-m-d",$timestop["time_add_stop"])."' ";
        
        //$limit=" limit $start,$limit ";
        $order=" ORDER BY $oS ";
        if($seq){
            $order.="ASC";
        }else{
            $order.="DESC";
        }
        //var_dump($sql.$where.$order);
        $result=M()->query($sql.$where.$order);
        $sql2="SELECT * FROM att_privilege";
        $result2=M()->query($sql2);
        if($result)$ret["r"]=1;
        $ret["sql"]=$sql.$where.$order;
        $ret["data"]=$result;
        $ret["privilege"]=$result2;
        $this->json_return($ret);
    }
    /**
     * 
     * @api {post} /index.php/Home/User/?action=user_pri_add 用户特权添加
     * @apiDescription 用户特权添加
     * @apiGroup ATT_privilege
     * @apiName user_pri_add
     * @apiParam {int} cardid 用户工号
     * @apiParam {int} privilege_id 特权id
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://www.ifrank.loan/index.php/Home/User/?action=user_pri_add
     *
     * @apiSuccess {json} data json数组对象
     */
    public function user_pri_add() {
        $ret=array("r"=>0,"msg"=>false);
        $REQ=$_REQUEST;
        $cardid=getReq($REQ,"cardid",0);
        $privilege_id=getReq($REQ,"privilege_id","");

        if(empty($cardid)||empty($privilege_id)){
            $ret["msg"]="cardid、privilege_id不能为空";
            $this->json_return($ret);
        }
        if(!is_numeric($cardid)){
            $ret["msg"]="cardid必须为数字";
            $this->json_return($ret);
        }
        if(!is_numeric($privilege_id)){
            $ret["msg"]="privilege_id必须为数字";
            $this->json_return($ret);
        }

        $sql_pri="SELECT * FROM att_privilege WHERE id=$privilege_id";
        $res_pri=M()->query($sql_pri);
        $time_add=date("Y-m-d H:i:s",time());
        $time_end=date("Y-m-d H:i:s",time()+$res_pri[0]['validity']*3600*24);
        $status=1;//1:可用的，2：过期的
        $sql="INSERT INTO att_privilege_u (cardid,privilege_id,privilege_name,time_add,privilege_validity,time_end,status) values (".$cardid.",".$privilege_id.",'".$res_pri[0]['name']."','".$time_add."',".$res_pri[0]['validity'].",'".$time_end."',".$status.")";
    
        $res=M()->execute($sql);
        if($res){
            $ret["r"]=1;
            $ret["msg"]="添加成功";
            $this->json_return($ret);
        }else{
            $ret["msg"]="添加失败";
            $this->json_return($ret);
        }
    }
    /**
     * 
     * @api {post} /index.php/Home/User/?action=user_pri_del 用户特权删除
     * @apiDescription 用户特权删除
     * @apiGroup ATT_privilege
     * @apiName user_pri_del
     * @apiParam {id} id 用户特权id 
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://www.ifrank.loan/index.php/Home/User/?action=user_pri_del
     *
     * @apiSuccess {json} data json数组对象
     */
    public function user_pri_del() {
        $ret=array("r"=>0,"msg"=>false);
        $REQ=$_REQUEST;
        $id=getReq($REQ,"id",0);
        if(empty($id)){
            $ret['msg']="id只能为数字且不能为空";
            return $ret;
        }
        $sql="DELETE FROM att_privilege_u WHERE id=$id";
        $res=M()->execute($sql);
        if($res){
            $ret=array("r"=>1,"msg"=>"删除成功");
        }
        $this->json_return($ret);
    }

    /**
     *
     * @api {post} /index.php/Home/User/?action=att_check_in 重置att_check表数据
     * @apiDescription 重置att_check表数据
     * @apiGroup ATT
     * @apiName att_check_in
     * @apiParam {Date} t_start 开始时间，格式例如：2016-08-03
     * @apiParam {Date} t_stop 结束时间，格式例如：2016-08-03
     * @apiVersion 0.1.0
     *
     *
     * @apiExample {curl} 访问示例：
     * curl -i http://hzrrkj.gnway.cc:8080/index.php/Home/User/?action=att_check_in&t_start=2016-08-03&t_stop=2016-08-03
     *
     * @apiSuccess {json} data json数组对象
     */

    public function att_check_in() {

        $t_start=$_REQUEST["t_start"];
        $t_stop=$_REQUEST["t_stop"];

        $t_start_t=strtotime($t_start);
        $t_stop_t=strtotime($t_stop);
        $day=60*60*24;
        $ret=array();

        for(;$t_start_t<$t_stop_t;){
            $sql_del="DELETE FROM dbo.att_check WHERE checkam between '".date("Y-m-d",$t_start_t)."' and '".date("Y-m-d",($t_start_t+$day))."' ";
            
            $del_num=M()->execute($sql_del);

            $tot_sql="select count(0) from dbo.CHECKINOUT";
            $sql="select n.name,n.BADGENUMBER as cardid,m.* from
                    (select top(200) ciu.USERID as USERID,min(ciu.CHECKTIME) as checkam,MAX(ciu.CHECKTIME) as checkpm
                    from dbo.CHECKINOUT as ciu
                    where ciu.CHECKTIME between '".date("Y-m-d",$t_start_t)."' and '".date("Y-m-d",($t_start_t+$day))."'
                    group by ciu.USERID
                    order by checkam ) m
                    inner join USERINFO n
                    on m.USERID=n.USERID";
            $tot=M()->query($tot_sql);
            $data=M()->query($sql);
            $res=M("att_check")->addall($data);

            $ret[]=array("del_num"=>$del_num,"startTime"=>date("Y-m-d",$t_start_t).' 00:00:00',"endTime"=>date("Y-m-d",($t_start_t+$day)).' 00:00:00',"data"=>$data);

            $t_start_t+=$day;         
        }
        $ret=array("t_start"=>$t_start,"t_stop"=>$t_stop,"date"=>$ret);
        echo $this->json_return($ret);
    } 

    private function json_return($arr){
        echo json_encode($arr);
        exit;
    }



}

function getReq($REQ,$par,$ret=""){
    return $REQ[$par]?$REQ[$par]:$ret;
}
