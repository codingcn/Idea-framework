<?php
/**
 *
 * @description     配置信息加载与获取
 * @author          Alan<20874823@qq.com>
 * @datetime        2016/10/4 13:18
 * @copyright       Copyright (c) 2016
 * @version         1.0
 */

namespace system;


/**
 * Class Config
 * @package system
 */
class Config
{
    private $config = [];
    private static $instance;


    /**
     * @return Config 获得单例对象
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * 加载配置文件
     * Config constructor.
     */
    private function __construct()
    {
        if (file_exists(CONFIG_FILE)) {

        }
        if (empty($this->config) && is_readable(CONFIG_FILE)) {
            return $this->config = include CONFIG_FILE;
        } else {
            return $this->config = [];
        }
    }

    private function __clone() {}

    /**
     * 获取配置参数
     * @param null $name 参数名
     * @return array|bool|mixed 参数值
     */
    public function get($name = null)
    {
        if (isset($this->config) && empty($name)) {
            return $this->config;
        }
        $path = explode('.', $name);
        $value = $this->config;
        foreach ($path as $param) {
            if (isset($value[$param])) {
                $value = $value[$param];
            } else {
                return false;
            }
        }
        return $value;
    }

    /**
     * 动态设置配置（递归）
     * @param $name string 配置值
     * @param $value string 配置参数
     * @return array
     */
    public function set($name, $value)
    {
        $path = explode('.', $name);
        for ($i = count($path) - 1; $i >= 0; $i--) {
            $value = [$path[$i] => $value];
        }
        $this->config = self::array_merge_multi($this->config, $value);
        return $this->config;
    }

    /**
     * [array_merge_multi description]
     * @return array 合并多维数组
     */
    private static function array_merge_multi()
    {
        $args = func_get_args();
        $array = [];
        foreach ($args as $arg) {
            if (is_array($arg)) {
                foreach ($arg as $k => $v) {
                    if (is_array($v)) {
                        $array[$k] = isset($array[$k]) ? $array[$k] : [];
                        $array[$k] = self::array_merge_multi($array[$k], $v);
                    } else {
                        $array[$k] = $v;
                    }
                }
            }
        }
        return $array;
    }
}
