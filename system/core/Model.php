<?php
/**
 * 系统运行加载类
 * @description     系统运行加载类
 * @author          Alan<20874823@qq.com>
 * @datetime        2016/4/22 13:12
 * @copyright       Copyright (c) 2016
 * @version         1.0
 */
namespace system;


class Model
{
    //存储实例化的数据库操作对象
    protected static $db;
    protected static $dsn_key;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        //pdo对象
        self::$db = self::connect();
    }

    /**
     * 选择数据源
     * @param $key string 数据源key
     * @return object pdo对象
     */
    protected static function connect($key = null)
    {
        self::$dsn_key = isset($key) ? $key : config('default_dsn');
        try {
            self::$db = Database::getInstance(self::$dsn_key);
        } catch (\PDOException $e) {
            echo '<h1>数据库异常！</h1>';
            echo '<p>异常信息：<b>' . $e->getMessage() . '</b></p>';
            echo '<p>异常信息追踪：<b>' . $e->getTraceAsString() . '</b></p>';
            exit;
        }
        return self::$db;
    }


    /**
     * 获得模型的单例对象
     * 针对所有模型 调用方法 $UserModel=self::getModel('User');
     * Helper.php内的方法model(模型名,模型方法名);进行调用该类
     * @param  string $model_name 需要得到单例对象的模型的名字，例如"User"或者"UserModel"
     * @return object 该模型类的单例对象
     */
    public static function getModel($model_name)
    {
        //储存所有的模型方法
        static $model_lists = []; //'User'=>Object(UserModel)
        //判断该模型类是否已经实例化对象
        if (!isset($model_lists[$model_name])) {
            //该模型类对象不存在，则实例化
            $model_class_name = $model_name;
            $model_lists[$model_name] = new $model_class_name();
        }
        //返回获取的模型对象
        return $model_lists[$model_name];
    }
}
