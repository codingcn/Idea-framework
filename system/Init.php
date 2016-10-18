<?php
/**
 * 初始化
 * @Description
 * @Copyright       Copyright(c) 2016
 * @Author          Alan
 * @E-mail          20874823@qq.com
 * @Datetime        2016/03/22 11:06:58
 * @Version         1.0
 */

namespace system;


define('FRAMEWORK_VERSION', 'V1.0');                                                      //框架版本
defined('ROOT_PATH') or define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/');  //绝对路径
defined('APP_NAME') or define('APP_NAME', 'application');                                 //网站应用目录
defined('APP_PATH') or define('APP_PATH', ROOT_PATH . APP_NAME . '/');                    //网站应用路径
defined('FRAMEWORK_NAME') or define('FRAMEWORK_NAME', 'system');                          //框架目录
defined('FRAMEWORK_PATH') or define('FRAMEWORK_PATH', ROOT_PATH . FRAMEWORK_NAME .'/');   //框架路径
defined('EXTEND_PATH') or define('EXTEND_PATH', APP_PATH . 'extend/');                    //扩展路径
defined('CONFIG_FILE') or define('CONFIG_FILE', APP_PATH . 'config/Config.php');          //包含用户配置文件

include FRAMEWORK_PATH . 'common/Helper.php';         //系统函数
include APP_PATH . 'common/Helper.php';               //用户函数
include FRAMEWORK_PATH . 'core/Config.php';           //系统配置
include FRAMEWORK_PATH . 'core/Loader.php';           //系统运行


if (false == config('display_errors')) {
    ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', config('error_log_file'));
} else {
	ini_set('display_errors', 'On');
}

Loader::run();