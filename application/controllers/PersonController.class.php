<?php

/**
 * 用户信息操作类
 * 
 */
class PersonController extends Controller {
  /**
   * 修改用户信息
   * @access public
   */
  public function alter() {
    $tokenInfo = $this->verifyToken();

    $queryInfo = json_decode(file_get_contents('php://input'), true);
    // 验证密码是否正确
    $directModel = new DirectModel('direct', []);
    $pasw = $directModel->getPasw($tokenInfo['sub']);
    if ($pasw != $queryInfo['oldPasw']) {
      $this->response(['data' => []], 403, '密码错误！');
    }

    isset($queryInfo['name']) ? $this->alterName($queryInfo) : '';
    isset($queryInfo['email']) ? $this->alterEmail($queryInfo) : '';
    isset($queryInfo['phone']) ? $this->alterPhone($queryInfo) : '';
    isset($queryInfo['newPasw']) ? $this->alterPasw($queryInfo) : '';
    isset($queryInfo['imageUrl']) ? $this->alterAvatar($queryInfo) : '';
  }

  /**
   * 修改用户名的方法
   * @access public
   * @param array $queryInfo
   */
  public function alterName($info) {
    $personModel = new PersonModel('person', []);
    $personModel->alterCol(['name' => $info['name']], ['pid' => $this->tokenInfo['sub']]);
  }
}