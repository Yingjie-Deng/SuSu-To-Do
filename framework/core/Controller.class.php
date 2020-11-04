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
     * @param string $token 需要验证的token
     *
     * @return string 成功返回string，失败重定向到登录页面
     */
    protected function verifyToken($token)
    {
        // 跳过预检
        if (isset($_SERVER['REQUEST_METHOD']) && 'OPTIONS' == $_SERVER['REQUEST_METHOD']) {
            exit();
        }

        $resTokenInfo = Jwt::verifyToken($token);
        if (!$resTokenInfo) {
            // $this->redirect('http://localhost/todo/login');
            $res = $GLOBALS['config']['res'];
            $res['meta']['status'] = 401;
            $res['meta']['msg'] = '未登录或登录失效';
            echo json_encode($res);
            exit();
        }

        return $resTokenInfo;
    }

    /**
     * 刷新token.
     *
     * @param string $pid
     *
     * @return string $token
     */
    protected function refresh($pid)
    {
        return $this->getToken([
      'iss' => 'admin',
      'iat' => time(),
      'exp' => time() + 7200,
      'nbf' => time(),
      'sub' => $pid,
      'jti' => md5(uniqid('JWT').time()),
    ]);
    }
}
