<?php
/**
 * 注册登录控制器
 * 继承于Controller
 */
class RegController extends Controller {

  // private $person = null;

  /**
   * 注册方法
   * @access public
   * @method POST
   */
  public function register() {
    $regInfo = file_get_contents('php://input');
    $regInfo = json_decode($regInfo, true);
    // var_dump($regInfo);
    $pid = $regInfo['name'] . time();

    // 组装 person 表的信息
    $personInfo['name'] = $regInfo['name'];
    $personInfo['pid'] = $pid;

    // 组装 手机登录 的信息
    $phone['pid'] = $pid;
    $phone['login_name'] = $regInfo['phone'];
    $phone['password'] = $regInfo['password'];

    // 组装 邮箱登录 的信息
    if ($regInfo['email']) {
      $email = $phone;
      $email['login_name'] = $regInfo['email'];
    }

    // 开始注册
    $person = new PersonModel('person');
    // $person->insert($personInfo);
    $person->begin();
    $ins1 = $person->insert_new($personInfo, 'person');
    $ins2 = $person->insert_new($phone, 'direct');
    if (isset($email)) {
      $ins3 = $person->insert_new($email, 'direct');
    }

    $res = $GLOBALS['config']['res'];
    // 检查是否都成功
    $sure = false;
    if ($ins1 && $ins2) {
      if (isset($ins3)) {
        if ($ins3) {
          $person->commit();
          $sure = true;
        } else {
          $person->back();
          $sure = false;
        }
      } else {
        $person->commit();
        $sure = true;
      }
    } else {
      $person->back();
      $sure = false;
    }

    // 结束事务
    $person->end();
    
    // 响应用户
    if ($sure) {
      $res['data'] = [
        'token' => $this->getToken([
          'iss' => 'admin',
          'iat' => time(),
          'exp' => time()+7200,
          'nbf' => time(),
          'sub' => $regInfo['name'],
          'jti' => md5(uniqid('JWT').time())
        ]),
        'pid' => $pid
      ];
      $res['meta']['msg'] = '注册成功';
      $res['meta']['status'] = 201;
      echo json_encode($res);
      exit();
    }
    $res['data'] = null;
    $res['meta']['msg'] = '注册失败';
    $res['meta']['status'] = 500;
    echo json_encode($res);
    exit();
  }

  /**
   * 登录功能
   * @access public
   * @method POST
   */
  public function login() {
    // $loginInfo['login_name'] = $_POST['login_name'];
    // $loginInfo['password'] = $_POST['password'];
    $loginInfo = file_get_contents('php://input');
    $loginInfo = json_decode($loginInfo, true);
    // var_dump($loginInfo);

    $model = new Mysql($GLOBALS['config']['db']);
    $sure = $model->getRow([
      'select' => 'pid',
      'from' => 'direct',
      'where' => "`login_name`='{$loginInfo['login_name']}' and `password`='{$loginInfo['password']}'"
    ]);
    // var_dump($sure);
    $res = $GLOBALS['config']['res'];
    if (isset($sure['pid'])) {
      $res['data']['token'] = $this->getToken([
        'iss' => 'admin',
        'iat' => time(),
        'exp' => time()+7200,
        'nbf' => time(),
        'sub' => $sure['pid'],
        'jti' => md5(uniqid('JWT').time())
      ]);
      $res['data']['pid'] = $sure['pid'];
      $res['meta']['msg'] = '登陆成功';
      $res['meta']['status'] = 200;
      echo json_encode($res, JSON_UNESCAPED_UNICODE);
      exit();
    }
    $res['data'] = null;
    $res['meta']['msg'] = '用户名或密码不正确';
    $res['meta']['status'] = 400;
    echo json_encode($res);
    exit();
  }
}