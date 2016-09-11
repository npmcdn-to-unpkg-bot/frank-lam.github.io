<?php
namespace Home\Controller\Index;
use Think\Controller;

/**
 * 操作绑定到类
 * Index控制器index操作方法
 */
class index extends Controller
{
    public function run() {
        echo "bind action";
    }
}
