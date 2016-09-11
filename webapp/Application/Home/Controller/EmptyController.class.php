<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 空控制器
 */
class EmptyController extends Controller
{
    
    /**
     * 空操作
     */
    public function _empty() {
        echo "您是怎么找到我的!";
    }
}
