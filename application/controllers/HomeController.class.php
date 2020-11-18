<?php

/**
 * home页面相关控制器，提供用户信息和清单信息
 */
class HomeController extends Controller {

  /**
   * 加载用户信息和清单信息
   * @access public
   */
  public function load() {
    // isset($_SERVER['HTTP_AUTHORIZATION']) ? $token =$_SERVER['HTTP_AUTHORIZATION'] : $token = '';
    $tokenInfo = $this->verifyToken();

    $res = $GLOBALS['config']['res'];
    $pInfoM = new PInfoModel('personInfo');
    $res['data']['pInfo'] = $pInfoM->getInfo($tokenInfo['sub']);
    // if ($newToken = $this->refresh($tokenInfo['sub'])) $res['data']['token'] = $newToken;
    $res['data']['token'] = $this->refresh($tokenInfo['sub']);
    $res['meta']['msg'] = 'OK';
    $res['meta']['status'] = 200;
    echo json_encode($res);
    exit();
  }
}