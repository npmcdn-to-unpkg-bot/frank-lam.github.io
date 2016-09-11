<?php

/**
 * 生成简单测试数组数据
 */
function getTestData() {
    $data = array();
    for ($i    = 0; $i < 10; $i++) {
        $data[$i]['name'] = 'user-' . $i;
        $data[$i]['age'] = rand(18, 90);
    }
    
    return $data;
}
