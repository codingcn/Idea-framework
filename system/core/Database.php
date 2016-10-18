<?php
/**
 * 数据库类
 * @Description    获取PDO对象
 * @Copyright      Copyright(c) 2016
 * @Author         Alan
 * @E-mail         20874823@qq.com
 * @Datetime       2016/06/25 08:42:00
 * @Version        1.0
 */
namespace system;


/**
 * Class Database
 * @package system
 */
class Database
{
    //私有静态变量，存储对象
    private static $instance = [];

    //使该类不能在类外实例化对象
    final private function __construct()
    {
    }

    //设置私有，防止对象通过克隆方法产生对象
    final private function __clone()
    {
    }

    /**
     * 获取数据库连接
     * @param string $key 数据库连接串标识
     * @return mixed PDO对象
     * @throws \Exception
     */
    public static function getInstance($key = '')
    {
        $dsn = config('dsn.' . $key);
        if (!isset($dsn)) {
            throw new Exception('数据库连接错误：不能识别的DSN：' . $key);
        }
        //如果还未连接，则连接
        if (!isset(self::$instance[$key])) {
            if (is_array($dsn)) {
                $temp = new \ReflectionClass('PDO');
                self::$instance[$key] = $temp->newInstanceArgs($dsn);
            } else {
                self::$instance[$key] = new \PDO($dsn);
            }
        }
        //返回连接
        return self::$instance[$key];
    }
}
