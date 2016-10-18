<?php
/**
 * 公共函数，放置用户自定义函数
 * @return [type] [description]
 */

/**
 * 格式化打印函数
 * @param mixed $val 传入的字符/数据/对象..
 * @param bool $dump 指定使用vardump();
 * @param bool $exit
 */
function debug($val, $dump = false, $exit = true)
{
    if ($dump) {
        $func = 'var_dump';
    } else {
        $func = (is_array($val) || is_object($val)) ? 'print_r' : 'printf';
    }
    echo '<pre>debug output:<hr />';
    $func($val);
    echo '</pre>';
}

/**
 * 打印框架已定义常量
 * @return mixed $constArr 数组格式所有的预定义常量
 */
function printConst()
{
    $constArr = get_defined_constants(true);
    echo '<pre>';
    var_dump($constArr['user']);
    echo '</pre>';
}