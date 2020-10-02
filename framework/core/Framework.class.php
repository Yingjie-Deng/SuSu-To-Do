<?php
class Framework
{
    public static function run()
    {
        self::init();
        self::autoload();
        self::route();
    }

    private static function init()
    {
        // 定义路径
        define("DS", DIRECTORY_SEPARATOR);
        define('ROOT', getcwd() . DS);
        define('APP_PATH', ROOT . 'application' . DS);
        define('FRAMEWORK_PATH', ROOT . 'framework' . DS);
        define('CONFIG_PATH', APP_PATH . 'config' . DS);
        define('CONTROLLER_PATH', APP_PATH . 'controllers' . DS);
        define('MODEL_PATH', APP_PATH . 'models' . DS);
        define('VIEW_PATH', APP_PATH . 'views' . DS);
        define('CORE_PATH', FRAMEWORK_PATH . 'core' . DS);
        define('DB_PATH', FRAMEWORK_PATH . 'database' . DS);
        define('INDEX_PATH', VIEW_PATH . 'dist' . DS . 'index.html');

        // 加载核心类文件
        require CORE_PATH . 'Controller.class.php';
        require DB_PATH . 'Mysql.class.php';
        require CORE_PATH . 'Model.class.php';

        // 加载配置文件
        $GLOBALS['config'] = include CONFIG_PATH . 'config.php';
    }
    private static function autoload()
    {
        spl_autoload_register(array(__CLASS__, 'load'));
    }
    private static function load($classname)
    {
        if (substr($classname, -10) == 'Controller') {
            require_once CONTROLLER_PATH . "$classname.class.php";
        } elseif (substr($classname, -5) == 'Model') {
            require_once MODEL_PATH . "$classname.class.php";
        }
        // if (substr($classname, -5) == 'Model') {
        //     require_once MODEL_PATH . "$classname.class.php";
        // } else {
        //     require_once CONTROLLER_PATH . "$classname.class.php";
        // }
    }
    private static function route()
    {
        define('REQ_METHOD', strtolower($_SERVER['REQUEST_METHOD']));
        define('PATH_INFO', isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/susu/home');
        $path = ltrim(PATH_INFO, '/susu/');
        $path_arr = explode('/', $path);
        // echo $path . PHP_EOL;
        // echo REQ_METHOD . PHP_EOL;
        // var_dump($path_arr);
        // if (REQ_METHOD == 'post') {
        //   $param = file_get_contents('php://input');
        // }
        $controller_name = ucfirst($path_arr[0]) . 'Controller';
        $action_name = $path_arr[1];
        
        if (!file_exists(CONTROLLER_PATH . "$controller_name.class.php")) {
            // 重定向
            $BaseController = new Controller();
            $BaseController->redirect("http://localhost/todo/home");
        } else {
            $controller = new $controller_name;
            if (!method_exists($controller, $action_name)) {
                // 重定向
                $BaseController = new Controller();
                $BaseController->redirect("http://localhost/todo/home");
            } else {
                $controller->$action_name();
            }
        }
        // echo $_SERVER['REQUEST_URI'];
        // echo $path;
    }
}
