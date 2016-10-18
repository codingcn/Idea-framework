<?php
/**
 * 后台公共控制器，继承控制器基类
 */
namespace app\home\controller;


/**
 * Class Common
 * @package app\home\controller
 */
class Common
{
    //模板目录
    public $tpl_path;

    public function __construct()
    {
    	$this->tpl_path = APP_PATH . 'home/view/default/';

    }

}