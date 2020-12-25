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
        define('USER', APP_PATH . 'user' . DS);
        define('TEMP', USER . 'temp' . DS);
        define('AVATAR', USER . 'avatar' . DS);
        define('CORE_PATH', FRAMEWORK_PATH . 'core' . DS);
        define('DB_PATH', FRAMEWORK_PATH . 'database' . DS);
        define('LIB_PATH', FRAMEWORK_PATH . 'libraries' . DS);

        // 加载核心类文件
        require CORE_PATH . 'Controller.class.php';
        require DB_PATH . 'Mysql.class.php';
        require CORE_PATH . 'Model.class.php';

        // 加载配置文件
        $GLOBALS['config'] = include CONFIG_PATH . 'config.php';

        // 加载Jwt鉴权库
        require LIB_PATH . 'jwt.php';
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
        define('PATH_INFO', isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/susu/home/enterError');
        /*
        $path = ltrim(PATH_INFO, '/susu/');
        $path_arr = explode('/', $path);
        */

        // ltrim() 有点儿坑，换方案
        // 此方案太 low 有待完善
        $path_arr_ori = explode('/', PATH_INFO);
        $path_arr[0] = $path_arr_ori[2];
        $path_arr[1] = $path_arr_ori[3];

        // echo $path . PHP_EOL;
        // echo REQ_METHOD . PHP_EOL;
        // var_dump($path_arr);
        // if (REQ_METHOD == 'post') {
        //   $param = file_get_contents('php://input');
        // }
# 调试代码
        // echo "path-Info:::::" . PATH_INFO;
        // echo "**path---------" . var_dump($path_arr_ori);
        // echo var_dump($path_arr);
        $controller_name = ucfirst($path_arr[0]) . 'Controller';
        $action_name = $path_arr[1];
# 调试代码
        // echo $path_arr[0];
        // echo ucfirst($path_arr[0]) . 'Controller';
        // echo '******' . $_SERVER['REQUEST_URI'];
        // exit();
        
        // if (!file_exists(CONTROLLER_PATH . "$controller_name.class.php")) {
        //     // 重定向
        //     // Controller::redirect("http://localhost/todo/home");

        // } else {
        //     $controller = new $controller_name;
        //     if (!method_exists($controller, $action_name)) {
        //         // 重定向
        //         Controller::redirect("http://localhost/todo/home");
        //     } else {
        //         $controller->$action_name();
        //     }
        // }
            $controller = new $controller_name;
            if (!method_exists($controller, $action_name)) {
                // 重定向
                Controller::redirect("http://localhost/todo/welcome");
            } else {
                $controller->$action_name();
            }
        // echo $_SERVER['REQUEST_URI'];
        // echo $path;
    }
}
