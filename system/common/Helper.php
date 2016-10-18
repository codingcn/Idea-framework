<?php
/**
 * 内置公共方法
 * @Description    公共方法
 * @Copyright      Copyright (c) 2016
 * @Author         Alan
 * @E-mail         20874823@qq.com
 * @Datetime       2016/05/09 15:34:16
 * @Version        1.0
 */


function config()
{
    $config = \system\Config::getInstance();
    $args = func_get_args();
    switch (func_num_args()) {
        case 0:
            return $config->get();
            break;
        case 1:
            return $config->get($args[0]);
            break;
        case 2:
            $config->set($args[0], $args[1]);
            break;
        default:
            return false;
            break;
    }
}

/**
 * 自定义Model方法，对模型类进行单例化
 * @param null $model_name
 * @param null $model_method
 * @return object
 */
function model($model_name = null, $model_method = null)
{
    if (is_null($model_method)) {
        $obj = \system\Model::getModel(config('app_namespace') . '\\' . MODULE . '\\' . config('model_dir') . '\\' . $model_name);
    } else {
        $obj = \system\Model::getModel(config('app_namespace') . '\\' . MODULE . '\\' . config('model_dir') . '\\' . $model_name)->$model_method();
    }
    return $obj;
}


/**
 * 类库加载函数
 * @param $class_file
 * @throws Exception
 */
function import($class_file)
{
    $class_path = config('extend_path') . trim($class_file, '/') . '.php';
    try {
        if (file_exists($class_path)) {
            include $class_path;
        } else {
            throw new \system\Exception("所加载类不存在，" . $class_path);
        }
    } catch (\system\Exception $e) {
        $e->getDetail();
    }
}

function notFound()
{
    header("HTTP/1.1 404 Not Found");
    header("status: 404 Not Found");
    include config('error_template');
    exit;
}

/**
 * 直接跳转方法
 * @access protected
 * @param string $jumpUrl 跳转地址
 */
function direct($jumpUrl = '')
{
    header("Location:$jumpUrl");
    exit;
}

/**
 * 等待提示跳转
 * @access protected
 * @param string $message 提示信息
 * @param string $jumpUrl 跳转地址
 * @param int $waitTime 跳转时间(单位：秒)
 */
function wait($jumpUrl = '', $message = '', $waitTime = 3)
{
    header("Refresh:$waitTime;URL=$jumpUrl");
    if (is_file($message)) {
        include $message;
    } else {
        echo $message;
    }
    exit;
}
