<?php
/**
 * 路由
 * @description     Idea框架路由类
 * @author          Alan<20874823@qq.com>
 * @datetime        2016/8/16 13:12
 * @copyright       Copyright (c) 2016
 * @version         1.0
 */
namespace system;


/**
 * Class Route
 * @package system
 */
class Route
{
    private $current_module;            //当前模块
    private $current_controller;        //当前控制器
    private $current_action;            //当前操作
    private $moduleDir;                 //模块目录
    private $controllerFile;            //控制器文件
    private $controllerClassName;       //控制器名
    private $controllerObj;

    /**
     * 加载配置信息
     */
    public function __construct()
    {
        //设置__ROOT__值
        $this->setRoot();
        //路由解析
        $this->parseUrl();
        //大小写判断
        $this->judgmentCase();
        //调用方法
        $this->newAction();
    }

    /**
     * 判断是否SSL协议
     * @return boolean
     */
    private static function isSsl()
    {
        if (isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))) {
            return true;
        } elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
            return true;
        }
        return false;
    }

    /**
     * 设置__ROOT__常量值
     */
    private function setRoot()
    {
        $scheme = self::isSsl() ? 'https://' : 'http://';
        if (PHP_SAPI != 'cli') {
            //服务器方式(URL)，项目的根路径，也就是网站根目录
            define('__ROOT__', trim($scheme . $_SERVER['HTTP_HOST'] . $_SERVER["SCRIPT_NAME"], '/'));
            define('ENTRANCE', substr(__ROOT__, strrpos(__ROOT__, '/') + 1));            //入口文件名
            define('__APP__', rtrim($scheme . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'], ENTRANCE) . APP_NAME);
        } else {
            // 当前应用地址
            define('__ROOT__', ROOT_PATH . '/');
            define('__APP__', rtrim(ROOT_PATH, ENTRANCE) . APP_NAME . '/');
        }
    }

    /**
     * 分发参数
     */
    private function parseUrl()
    {
        if (config('url_mode') == '1') {
            $this->current_module = isset($_GET['m']) ? $_GET['m'] : config('default_module');
            //通过判断url里面是否存在c参数，如果没有则设为默认控制器
            $this->current_controller = isset($_GET['c']) ? $_GET['c'] : config('default_controller');
            $this->current_action = isset($_GET['a']) ? $_GET['a'] : config('default_action');
        } elseif (config('url_mode') == '2') {
            if (isset($_SERVER['PATH_INFO'])) {
                $paths = explode(config('path_separator'), trim($_SERVER['PATH_INFO'], '/'));
                $url_module = array_shift($paths);
                $url_controller = array_shift($paths);
                $url_action = array_shift($paths);
                //传值操作
                for ($i = 0; $i < count($paths); $i += 2) {
                    if (isset($paths[$i + 1])) {
                        $_GET[$paths[$i]] = $paths[$i + 1];
                    } elseif (config('display_errors') == false) {
                        notFound();
                    } else {
                        throw new Exception($paths[$i] . '未设置一个参数值');
                    }
                }
            }
            $this->current_module = !empty($url_module) ? $url_module : config('default_module');
            //通过判断url里面是否存在c参数，如果没有则设为默认控制器
            $this->current_controller = !empty($url_controller) ? $url_controller : config('default_controller');
            $this->current_action = !empty($url_action) ? $url_action : config('default_action');
        } else {
            throw new Exception('不存在的路由参数url_mode，' . config('url_mode'));
        }
    }

    /**
     * 字符串命名风格转换
     * type 0 将Java风格转换为C的风格（下划线分割）
     *      1 将C风格转换为Java的风格（大驼峰）
     *      2 转型为小驼峰
     * @param string $name 字符串
     * @param boolean $type 转换类型
     * @return string
     */
    private static function parseName($name, $type = 0)
    {
        if ($type == 0) {
            $replace = preg_replace_callback(
                '/' . config('url_case_separator') . '([a-zA-Z])/',
                function ($match) {
                    return strtoupper($match[1]);
                },
                $name);
            return ucfirst($replace);
        } elseif ($type == 1) {
            $replace = strtolower(trim(preg_replace('/[A-Z]/', config('url_case_separator') . '\0', $name), config('url_case_separator')));
            return $replace;
        } elseif ($type == 2) {
            $replace = preg_replace_callback(
                '/' . config('url_case_separator') . '([a-zA-Z])/',
                function ($match) {
                    return strtoupper($match[1]);
                },
                $name);
            return $replace;
        }
    }

    /**
     * 判断大小写并定义url常量
     */
    private function judgmentCase()
    {
        $url_case = config('url_case');

        define('MODULE', $this->current_module);
        define('CONTROLLER', $url_case ? self::parseName($this->current_controller, 0) : $this->current_controller);
        define('ACTION', $url_case ? self::parseName($this->current_action, 2) : $this->current_action);

        if (config('url_mode') == '1') {
            define('__MODULE__', __ROOT__ . '?m=' . MODULE);
            define('__CONTROLLER__', __MODULE__ . '&c=' . CONTROLLER);
            define('__ACTION__', __CONTROLLER__ . '&a=' . ACTION);
        } elseif (config('url_mode') == '2') {
            define('__MODULE__', __ROOT__ . '/' . MODULE);
            define('__CONTROLLER__', __MODULE__ . config('path_separator') . CONTROLLER);
            define('__ACTION__', __CONTROLLER__ . config('path_separator') . ACTION);
        }

        $this->controllerClassName = config('app_namespace') . '\\' . MODULE . '\\' . config('controller_dir') . '\\' . CONTROLLER;
        //模块文件夹
        $this->moduleDir = APP_PATH . MODULE;

        //控制器文件
        $this->controllerFile = $this->moduleDir . '/' . config('controller_dir') . '/' . CONTROLLER . '.php';
    }

    /**
     * 实例化控制器并调用操作
     */
    private function newAction()
    {
        if (!is_dir($this->moduleDir)) {
            if (config('display_errors') == false) {
                notFound();
            } else {
                throw new Exception('不存在的模块，' . $this->moduleDir);
            }
        } elseif (!file_exists($this->controllerFile)) {
            if (config('display_errors') == false) {
                notFound();
            } else {
                throw new Exception('不存在的控制器，' . $this->controllerFile);
            }
        }
        if (class_exists($this->controllerClassName)) {
            $this->controllerObj = new $this->controllerClassName();
        } elseif (config('display_errors') == false) {
            notFound();
        } else {
            throw new Exception($this->controllerClassName . '控制器类不存在');
        }

        if (method_exists($this->controllerClassName, ACTION)) {
            //开始实例方法
            $this->controllerObj->{ACTION}(); //可变方法
        } elseif (config('display_errors') == false) {
            notFound();
        } else {
            throw new Exception(ACTION . '操作方法不存在');
        }

    }
}
