<?php
/**
 * 后台入口控制器
 * @Description
 * @Copyright     Copyright(c) 2016
 * @Author        Alan
 * @E-mail        20874823@qq.com
 * @Datetime      2016/05/10 21:11:35
 * @Version       1.0
 */
namespace app\admin\controller;


/**
 * Class Index
 * @package app\admin\controller
 */
class Index extends \app\admin\controller\Common
{
    /**
     * 输出后台首页
     * @return string [description]
     */
    public function index()
    {
        echo '欢迎访问后台，<a href="index.php">返回</a>';
    }
}