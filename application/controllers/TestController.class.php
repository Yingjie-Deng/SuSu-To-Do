<?php
/**
 * 测试用
 * 框架开发过程中用于测试模型功能实现情况
 */
class TestController
{
    public function haha()
    {
        echo 'enter haha.';
        // var_dump($GLOBALS['config']);
        // echo $GLOBALS['config']['db']['port'] . '<br>';
        // var_dump($GLOBALS['config']['res']);
        $testMysql = new Mysql($GLOBALS['config']['db']);
        $res = $testMysql->getRow([
        'from' => 'personInfo',
        'order' => 'login_name DESC'
    ]);
        // var_dump($res);
        // echo '<br>' . $testMysql->sql;
        echo stripslashes(json_encode($res));
    }

    public function select() {
      $model = new Mysql($GLOBALS['config']['db']);
      $res = $model->getAll([
        'from' => 'myday',
      ]);
      $response = $GLOBALS['config']['res'];
      $response['data'] = $res;
      $response['meta']['msg'] = '查询成功';
      $response['meta']['status'] = 200;
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
      // echo stripslashes(json_encode($response));
    }

    public function ins()
    {
        $Model = new Model('task', ['my_day', 'important']);
        // $list = $Model->preprocess([
        //   'tid' => 'test123',
        //   'pid' => 'test09:37:39',
        //   'content' => '测试新的插入方法insert',
        //   'found_time' => date("Y-m-d H:i:s"),
        //   'start_time' => date("Y-m-d H:i:s"),
        //   'my_day' => true
        // ]);
        // $list['my_day'] = true;
        echo $Model->insert([
          'tid' => 'test123456',
          'pid' => 'test09:37:39',
          'content' => '测试新的预处理方法preprocess',
          'found_time' => date("Y-m-d H:i:s"),
          'start_time' => date("Y-m-d H:i:s"),
          'my_day' => true
        ]);
    }
    public function ins2()
    {
        $param = file_get_contents('php://input');
    
        $param = json_decode($param, true);
        // var_dump($param);
        $Model = new Model('task');
        $list = $Model->preprocess($param);
        isset($list['my_day']) ? $list['my_day'] = $param['my_day'] : '';
        isset($list['important']) ? $list['important'] = $param['important'] : '';
        echo $Model->insert($list);
    }
    
    public function update() {
      $Model = new Model('task', ['my_day', 'important']);
      // echo $Model->update([
      //   'set' => ['deadline' => date("Y-m-d H:i:s")],
      //   'where' => ['tid' => 'test123456']
      // ]);
      echo $Model->update([
        'set' => ['important' => true],
        'where' => ['tid' => 'test123456']
      ]);
    }

    public function delete() {
      $model = new Model('task', ['my_day', 'important']);
      echo $model->delete([
        'tid' => ''
      ]);
    }
}
