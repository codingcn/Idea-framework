<?php
/**
 * 异常类
 * @description
 * @author          Alan<20874823@qq.com>
 * @datetime        2016/10/13 17:55
 * @copyright       Copyright (c) 2016
 * @version         1.0
 */

namespace system;


/**
 * Class Exception
 * @package system
 */
class Exception extends \Exception
{
    /**
     * NotFoundException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct($message, $code = 0)
    {
        // 确保所有变量都被正确赋值 
        parent::__construct($message, $code);
    }

    public function getDetail()
    {
        echo '<h1>出现异常了！</h1>';
        $msg = '<p>错误内容：<b>' . $this->getMessage() . '</b></p>';
        $msg .= '<p>异常抛出位置：<b>' . $this->getFile() . '</b>，第<b>' . $this->getLine() . '</b>行</p>';
        $msg .= '<p>异常追踪信息：<b>' . $this->getTraceAsString() . '</b></p>';
        echo $msg;
        exit;
    }
}
