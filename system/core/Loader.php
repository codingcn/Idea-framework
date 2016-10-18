<?php
/**
 * 系统运行加载类
 * @description     系统运行加载类
 * @author          Alan<20874823@qq.com>
 * @datetime        2016/8/16 13:12
 * @copyright       Copyright (c) 2016
 * @version         1.0
 */
namespace system;

/**
 * Class Loader
 * @package system
 */
class Loader
{

    private static $prefixes = [];

    public static function run()
    {
        self::setHeader();
        //系统类映射
        self::getMapList();
        // 注册自动加载ideaAutoload方法
        self::register();
        self::composerload();
        //实例化路由
        try {
            new Route();
        } catch (Exception $e) {
            $e->getDetail();
        }
    }
    private static function setHeader()
    {
        header("Content-type:text/html;Charset=".config('default_charset'));
        date_default_timezone_set(config('default_timezone'));
    }

    /**
     * 注册自动加载
     *
     * @return void
     */
    public static function register()
    {
        spl_autoload_register('self::ideaAutoload');
    }

    /**
     * 为命名空间前缀添加一个对应的基目录.
     *
     * @param string $prefix 命名空间前缀.
     * @param string $base_dir 基目录
     * namespace.
     * @param bool $prepend 前缀一致的两个base_dir,为true的在列表最开始插入
     * @return void
     */

    public static function addNamespace($prefix, $base_dir, $prepend = false)
    {
        //格式化命名空间前缀，以反斜杠结束
        $prefix = trim($prefix, '\\') . '\\';
        //格式化基目录以正斜杠结尾
        $base_dir = rtrim($base_dir, '/') . DIRECTORY_SEPARATOR;
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';
        //初始化命名空间前缀数组
        //如果前缀已存在数组中则跳过，否则存入数组
        if (isset(self::$prefixes[$prefix]) === false) {
            self::$prefixes[$prefix] = [];
        }

        if ($prepend) {
            //命名空间前缀相同时，后增基目录
            array_unshift(self::$prefixes[$prefix], $base_dir);
        } else {
            //前增
            array_push(self::$prefixes[$prefix], $base_dir);
        }
    }

    private static function getMapList()
    {
        foreach (Config::getInstance()->get('namespace_map_list') as $key => $value) {
            self::addNamespace($key, $value);
        }
    }

    /**
     * IdeaPHP框架自动加载方法
     * @param string $class_name 自动加载类/接口名
     * @return bool|mixed 映射文件名存在就加载，否则返回false
     */
    private static function ideaAutoload($class_name)
    {
        // 当前命名空间前缀
        $prefix = $class_name;
        //从后面开始遍历完全合格类名中的命名空间名称，来查找映射的文件名
        while (false !== $pos = strrpos($prefix, '\\')) {
            // 命名空间前缀
            $prefix = substr($class_name, 0, $pos + 1);
            // 相对的类名
            $relative_class = substr($class_name, $pos + 1);
            //尝试加载与映射文件相对的类
            $mapped_file = self::loadMappedFile($prefix, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }
            //去除前缀的反斜杠
            $prefix = rtrim($prefix, '\\');
        }
        return false;
    }

    /**
     * 根据命名空间及相对类来加载映射文件.
     *
     * @param string $prefix 命名空间前缀
     * @param string $relative_class 相对类名
     * @return mixed Boolean 没有映射文件被加载为 false
     */

    private static function loadMappedFile($prefix, $relative_class)
    {
        //这个命名空间前缀是否存在基本的目录？
        if (isset(self::$prefixes[$prefix]) === false) {
            return false;
        }

        $relative_class = str_replace('\\', '/', $relative_class);

        foreach (self::$prefixes[$prefix] as $base_dir) {
            $file = $base_dir . $relative_class . '.php';
            // 如果映射文件存在就加载它
            if (self::requireFile($file)) {
                // 做一其他事
            }
        }
        return false;
    }

    /**
     * 如果文件存在，就从文件系统加载它
     *
     * @param string $file 加载文件
     * @return bool 文件存在 true
     */
    private static function requireFile($file)
    {
        if (file_exists($file)) {
            include $file;
            return true;
        }
        return false;
    }
    private static function composerload()
    {
        //composer自动加载
        file_exists(config('composer_aotuload_file')) ? include config('composer_aotuload_file') : false;
    }
}

