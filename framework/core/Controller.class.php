<?php
/**
 * 基础控制器类
 */
class Controller {
  // protected $jwt;

  // public function __construct() {
  //   $this->jwt = new Jwt();
  // }

  /**
   * 重定向
   * @access public
   * @param $url 用于重定向的URL
   */
  public static function redirect($url) {
    header("Location: $url");
  }

  /**
   * 获取token
   * @access protected
   * @param array $payload JWT 载荷
   * @return mixed bool | string 成功返回 JWT 令牌；失败返回false
   */
  protected function getToken($payload) {
    return Jwt::getToken($payload);
  }
  
  /**
   * 验证token是否有效
   * @access protected
   * @param string $token 需要验证的token
   * @return string 成功返回string，失败重定向到登录页面
   */
  protected function verifyToken($token) {
    $resTokenInfo = Jwt::verifyToken($token);
    if (!$resTokenInfo) {
      $this->redirect('http://localhost/todo/login');
    }
    return $resTokenInfo;
  }
}