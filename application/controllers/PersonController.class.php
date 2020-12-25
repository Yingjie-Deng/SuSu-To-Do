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
    // 若密码错误，直接返回
    if ($pasw != $queryInfo['oldPasw']) {
      $this->response(['data' => []], 403, '密码错误！');
    }

    isset($queryInfo['name']) ? $this->alterName($queryInfo) : '';
    isset($queryInfo['email']) ? $this->alterEmail($queryInfo) : '';
    isset($queryInfo['phone']) ? $this->alterPhone($queryInfo) : '';
    isset($queryInfo['newPasw']) ? $this->alterPasw($queryInfo) : '';
    isset($queryInfo['imageUrl']) ? $this->alterAvatar($queryInfo) : '';

    // 修改完成
    $res['data'] = [];
    $this->response($res);
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

  /**
   * 修改邮箱的方法
   * @access public
   * @param array $queryInfo
   */
  public function alterEmail($info) {
    // 判断用户是否填写过邮箱
    $directModel = new DirectModel('direct');
    $count = $directModel->count($this->tokenInfo['sub']);
    if ($count == 0) {
      // 插入一条邮箱登录信息
      $query = ['login_name' => $info['email']];
      isset($info['newPasw']) ? $query['password'] = $info['newPasw'] : $query['password'] = $info['oldPasw'];
      $query['pid'] = $this->tokenInfo['sub'];

      $directModel->insert($query);
    } else {
      // 邮箱已存在，对其进行修改
      $directModel->strUpdate("
        UPDATE `direct`
        SET `login_name` = '{$info['email']}'
        WHERE  `pid` = '{$this->tokenInfo['sub']}' AND `login_name` LIKE '%@%';
      ");
    }
  }

  /**
   * 修改手机号的方法
   * @access public
   * @param array $queryInfo
   */
  public function alterPhone($info) {
    $directModel = new DirectModel('direct');
    $directModel->strUpdate("
    UPDATE `direct`
    SET `login_name` = '{$info['phone']}'
    WHERE  `pid` = '{$this->tokenInfo['sub']}' AND `login_name` LIKE '1__________';
    ");
  }

  /**
   * 修改密码的方法
   * @access public
   * @param array $queryInfo
   */
  public function alterPasw($info) {
    $directModel = new DirectModel('direct');
    $directModel->strUpdate("
    UPDATE `direct`
    SET `password` = '{$info['newPasw']}'
    WHERE  `pid` = '{$this->tokenInfo['sub']}';
    ");
  }

  /**
   * 修改头像的方法
   * @access public
   * @param array $queryInfo
   */
  public function alterAvatar($info) {
    $personModel = new PersonModel('person');
    $exarray = explode('.', $info['temp_path']);
    $extension = end($exarray);
    $temp = TEMP . "{$this->tokenInfo['sub']}.$extension";
    $realPath = iconv('UTF-8', 'GBK', AVATAR . "{$this->tokenInfo['sub']}.$extension");
    if (copy($temp, $realPath)) {
      // 拷贝成功，需要删除临时图片，修改数据库
      unlink($temp);
      $personModel->update([
        'set' => ['head_sculpture' => "http://localhost/todo/application/user/avatar/{$this->tokenInfo['sub']}.$extension"],
        'where' => ['pid' => "{$this->tokenInfo['sub']}"]
      ]);
    } else {
      $this->response(['data' => []], 400, '拷贝图片失败！');
    }

  }
}