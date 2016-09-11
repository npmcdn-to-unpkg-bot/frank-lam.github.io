<?php  
require_once('config.php');  
if(empty($_FILES) || empty($_REQUEST)){  
	header('location:imgupload.php');  
	exit;  
}  

array_push($_FILES, $_REQUEST);  

$filename = 'fileToUpload';  
$product = @$_FILES[0]['product'];  
$today = date("Y-m-d");  
$time = date("YmdHis");   
$year = date("Y");  
$month = date("m");  
$day = date("d");  
$img_path = $product.'/'.$year.'/'.$month.'/'.$day.'/';  
$destination_dir = ROOT_PATH.'/pic/'.$img_path.'/';  

if(!is_uploaded_file($_FILES[$filename]['tmp_name'])){//验证上传文件是否存在  
	echo "请选择你想要上传的图片";  
	exit;  
}  

if($product == "") {//选择产品  
	echo "请选择产品";  
	exit;  
}  
$files = $_FILES[$filename];  

    if($max_file_size < $files['size']){//判断文件是否超过限制大小  
    	echo "图片太大了,传个小点的吧(<=2MB)";  
    	exit;  
    }  
    
    if(!file_exists($destination_dir)) {//判断上传目录是否存在,不存在则创建一个.  
    	if(!mkdir($destination_dir,0777,true)) {  
    		echo "创建目录 {".$destination_dir."} 失败<可能是权限问题>";  
    		exit;  
    	}  
    }  
    $type = pathinfo($files['name']);  
    $type = strtolower($type["extension"]);  
    $type =".".$type;  
    $tmp_name = $files['tmp_name'];  
    $md5file = md5_file($tmp_name);//生成md5文件  
    $new_name =$md5file.$type;  
    $img_relat_path = $img_path.$new_name;  
    $img_abs_path = $destination_dir.$new_name;  
    
    $url = IMG_URL.$img_relat_path;  
    
    //判断数据库中图片是否存在  
    $sql="select url from file_url where md5 = '".$md5file."'";  
    $res=$db->getOne($sql);  
    if($res) {  
    	echo $res['url'];  
    	exit;   
    }        
    
    if(!move_uploaded_file ($files['tmp_name'], $img_abs_path)) {//上传文件  
    	echo "上传文件失败";  
    	exit;  
    }  
        //将图片存入数据库         
    $sql="insert into file_url(url,product,md5,create_time) values('".$url."','".$product."','".$md5file."','".$today."')";  
    $db->Execute($sql);  
    $db->CloseDB();  
    echo $url;  
    ?>  