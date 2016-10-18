<?php
/**
 * 公共配置信息
 */
return [

    /**
     * 命名空间映射列表,自动加载依赖
     * system为框架命名空间，不建议修改，如果修改还需要修改框架所有文件中的命名空间定义
     * app为应用命名空间，修改该项之后，还需指定app_namespace为相关值
     */
    'namespace_map_list' => [
        'system' => FRAMEWORK_PATH . 'core',
        'app'    => ROOT_PATH . 'application',
        //'test' => ROOT_PATH.'test',
    ],
    /**
     * 应用类库的根命名空间
     */
    'app_namespace' => 'app',


    /**
     * 文件（包括控制器/模型/类库等）命名均为pascal命名
     *
     * 默认命名空间及目录均为小写模式
     *
     * 设置为true即开启pascal命名法
     * 目录及命名空间首字母需大写
     *
     */
    'default_charset' => 'UTF-8',
    'default_timezone' => 'PRC',



    /**
     * true为显示错误
     * 错误显示开关
     */
    'display_errors' => true,

    /**
     * 该项仅在(display_errors = false)条件下有效
     * 页面错误模板（404页面）
     */
    'error_template' => APP_PATH . 'common/404/index.php',
    /**
     * 该项仅在(display_errors = false)条件下有效
     * php错误写到日志文件
     */
    'error_log_file' => APP_PATH . 'log/php.error.log',



    /**
     * URL大小写配置，true为不区分大小写，false为区分
     * 推荐设置为区分大小写
     */
    'url_case' => true,
    /**
     * 仅当url_case为true时，该项有效
     * URL驼峰命名分隔符
     * 该项不能与path_separator设为相同值，避免冲突
     *
     * 当控制器或操作方法的命名是两个单词拼接时，且使用驼峰法
     * 下面两种URL写法是等效的，
     *  http://servername.com/Idea-framework/index.php/home/MyClass/sayHello
     *  http://servername.com/Idea-framework/home/my_class/say_hello
     */
    'url_case_separator' => '_',


    /**
     * 应用扩展目录
     * 该项为框架内置import()函数提供支持
     */
    'extend_path' => APP_PATH . 'extend/',

    /**
     * composer自动加载文件引入
     */
    'composer_aotuload_file' => APP_PATH . 'vendor/autoload.php',


    /**
     * 设置默认操作
     * 严格区分大小写，请正确设置
     */
    'model_dir' => 'model',      //模型目录
    'controller_dir' => 'controller', //控制器目录
    'default_module' => 'home',        //默认模块（平台、分组）
    'default_controller' => 'Index',        //默认控制器（该项首字母必须大写，因为控制器文件名是大驼峰命名的）
    'default_action' => 'index',        //默认控制器方法


    /**
     * URL路由模式选择
     * 1. 普通模式  如：http://servername.com/index.php?m=Home&c=User&a=login
     * 2. PATHINFO  如：http://servername.com/index.php/Home/User/login
     * 3. 当配置伪静态后，URL可以更加简洁，如http://servername.com/Home/User/login
     */
    'url_mode' => '1',

    /**
     * url_mode为2时该项生效
     * URL分割符，在开启PATHINFO模式下有效，如：http://servername.com/index.php/Home-User-login
     * * 该项不能与url_case_separator设为相同值，避免冲突
     */
    'path_separator' => '/',

    /**
     * 设置默认dsn,必须在dsn列表中存在
     *
     */
    'default_dsn' => 'master',

    /**
     * dsn列表
     * 更多dsn设置可以参考PHP官方手册
     */
    'dsn' => [
        'master' => [
            'mysql:127.0.0.1;port=3306;dbname=mydb',
            'root',
            '123456',
            [
                //array $driver_options
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8"',
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => false,
                //更多驱动选项请参考PHP手册
            ]
        ],
        'mysql_slave1' => [
            'mysql:host=localhost;port=3306;dbname=test',
            'root',
            '123456',
            [
                //array $driver_options
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8"',
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        ],
        /*
        'mssql'   => [
            'odbc:Driver={SQL Server};Server=localhost;Database=mydb',
            'sa',
            '123456'
        ],

        'oci'     => ['oci:dbname=//db.example.com:1521/mydb','username','password'],

        'sqlite'  => 'sqlite:c:/data/sqlite.db',

        'postgreSQL'=>[pgsql:host=localhost;port=5432;dbname=testdb],
        */
    ],


    //这里可以添加更多自己的配置

];