<?php
/**
 * 首页控制器，继承公共控制器类
 */
namespace app\home\controller;


/**
 * Class Index
 * @package app\home\controller
 */
class Index extends Common
{
    public function index()
    {
        $isPdo = extension_loaded('pdo_mysql');
        $ok = "<h1>框架已成功部署，</h1>";
        $ok .= "<h1>欢迎使用 Idea framework!</h1>";
        $ok .= "
			<a href='http://ideait.net' target='_blank'>Idea官网</a>
			<a href='http://www.kancloud.cn/yunfei_z/framework/136200' target='_blank'>在线手册  </a>
			<a href='" . __ROOT__ . "?m=admin' target='_blank'>后台管理</a>";
        $no = '<h2>Warning：服务器环境错误！</h2>
	错误信息：没有开启pdo_mysql扩展！<br>
	帮助信息：请尝试打开php.ini将 去除;extension=php_pdo_mysql.dll 前面的分号，并重启服务器';
        require $this->tpl_path . 'index/index.php';
    }
}
