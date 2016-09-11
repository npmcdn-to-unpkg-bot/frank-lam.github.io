<?php
function get_age($year) {
    $now = date('Y');
    if ($year > $now) {
        return '数据错误';
    }
    return $now - $year;
}

/**
 * 获取好友测试数据
 * @return array
 */
function get_user_friends($id='') {
    $friends = array(
        array(
            'username' => '张三'.$id ,
            'avatar' => null,
            'age' => 30,
            'tags' => array('游泳', '羽毛球', '程序员')
        ) ,
        array(
            'username' => '李四'.$id ,
            'avatar' => '1.jpg',
            'age' => 26,
            'tags' => array( '看电影','足球', '登山')
        ) ,
        array(
            'username' => '小红'.$id ,
            'avatar' => '2.jpg',
            'age' => 35,
            'tags' => array('逛街','手机控','单身一族')
        ) ,
        array(
            'username' => '小明'.$id,
            'avatar' => '3.jpg',
            'age' => 16,
            'tags' => array('资深学生','语出惊人','段子')
        )
    );
    
    return $friends;
}
?>