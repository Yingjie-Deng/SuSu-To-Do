<?php
/**
 * 基础控制器类.
 */
class Controller
{
    // protected $jwt;

    // public function __construct() {
    //   $this->jwt = new Jwt();
    // }

    /**
     * 用户token信息
     * @access protected
     * @type array
     */
    protected $tokenInfo;

    /**
     * 重定向.
     *
     * @param $url 用于重定向的URL
     */
    public static function redirect($url)
    {
        header("Location: $url");
    }

    /**
     * 获取token.
     *
     * @param array $payload JWT 载荷
     *
     * @return mixed bool | string 成功返回 JWT 令牌；失败返回false
     */
    protected function getToken($payload)
    {
        return Jwt::getToken($payload);
    }

    /**
     * 验证token是否有效.
     *
     * @access protected
     * @return string 成功返回string，失败返回未登录json字符串给前端
     */
    protected function verifyToken()
    {
        // 跳过预检
        if (isset($_SERVER['REQUEST_METHOD']) && 'OPTIONS' == $_SERVER['REQUEST_METHOD']) {
            exit();
        }

        isset($_SERVER['HTTP_AUTHORIZATION']) ? $token = $_SERVER['HTTP_AUTHORIZATION'] : $token = '';
        $resTokenInfo = Jwt::verifyToken($token);
        if (!$resTokenInfo) {
            // $this->redirect('http://localhost/todo/login');
            $res = $GLOBALS['config']['res'];
            $res['meta']['status'] = 401;
            $res['meta']['msg'] = '未登录或登录失效';
            echo json_encode($res);
            exit();
        }

        return $this->tokenInfo = $resTokenInfo;
    }

    /**
     * 刷新token.
     *
     * @access protected
     * 
     * @param string $pid
     *
     * @return string $token
     */
    protected function refresh($pid)
    {
        $newtoken =  $this->getToken([
            'iss' => 'admin',
            'iat' => time(),
            'exp' => time() + 7200,
            'nbf' => time(),
            'sub' => $pid,
            'jti' => md5(uniqid('JWT').time()),
        ]);
        if ($newtoken) {
            return $newtoken;
        } else {
            return $_SERVER['HTTP_AUTHORIZATION'];
        }
    }

    /**
     * 响应用户
     * @access protected
     * @param array, number, string; $res, $status, $msg
     * 
     */
    protected function response($res, $status = 200, $msg = 'OK') {
        $res['data']['token'] = $this->refresh($this->tokenInfo['sub']);
        $res['meta']['msg'] = $msg;
        $res['meta']['status'] = $status;
        echo json_encode($res);
        exit();
    }
}
