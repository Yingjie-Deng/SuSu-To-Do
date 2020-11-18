<?php

/**
 * 任务加载、修改、新增、删除
 */
class TasksController extends Controller {

  /**
   * 查询“我的一天”任务记录
   * @access public
   */
  public function myday() {
    $tokenInfo = $this->verifyToken();

    $mydayModel = new MydayModel('myday', ['important']);
    $res['data']['myday_tasks'] = $mydayModel->getTasks();
    $res['meta']['msg'] = 'OK';
    $res['meta']['status'] = 200;
    $res['data']['token'] = $this->refresh($tokenInfo['sub']);
    echo json_encode($res);
    exit();
  }

  /**
   * 获取用户的任务清单
   * @access public
   */
  public function loadList() {
    $tokenInfo = $this->verifyToken();

    $listModel = new ListModel('list');
    $res['data']['list'] = $listModel->loadList($tokenInfo['sub']);
    // $res['data']['token'] = $this->refresh($tokenInfo['sub']);
    // $res['meta']['msg'] = 'OK';
    // $res['meta']['status'] = 200;
    // echo json_encode($res);
    // exit();

    // -------------------
    $this->response($res);
  }

  /**
   * 插入记录
   * @access public
   */
  public function addTask() {
    $tokenInfo = $this->verifyToken();

    // 封装 task 数据
    $taskInfoJson = file_get_contents('php://input');
    $taskInfo = json_decode($taskInfoJson, true);
    $taskInfo['pid'] = $tokenInfo['sub'];
    $taskInfo['tid'] = 't' . time() . rand(1111, 9999);
    isset($taskInfo['my_day']) ? '' : $taskInfo['my_day'] = 0;
    isset($taskInfo['important']) ? '' : $taskInfo['important'] = 0;

    // 处理数据
    $taskModel = new TaskModel('task', ['my_day', 'important']);
    $res['data']['msg'] = $taskModel->addOneTask($taskInfo);

    // 响应数据
    $this->response($res, 201);
  }

  /**
   * 切换重要性
   * @access public
   * 
   */
  public function toggleImpt() {
    $tokenInfo = $this->verifyToken();

    // 获取更新信息
    $toggleInfo = file_get_contents('php://input');
    $toggleInfo = json_decode($toggleInfo, true);

    // 封装更新‘列’
    $toggleSet['important'] = $toggleInfo['important'];
    if (!$toggleSet['important']) {
      // false 转字符串时会转换为空字符串，故使用 0 代替 false
      $toggleSet['important'] = 0;
    }

    // 封装更新条件
    $toggleWhere['tid'] = $toggleInfo['tid'];
    $toggleWhere['pid'] = $tokenInfo['sub'];

    $setAndWhere['set'] = $toggleSet;
    $setAndWhere['where'] = $toggleWhere;

    // 处理数据
    $taskModel = new TaskModel('task', ['my_day', 'important']);
    $res['data']['msg'] = $taskModel->changeImpt($setAndWhere);

    // 响应数据
    $this->response($res, 204);
  }

  /**
   * 切换任务完成与否
   */
  public function toggComplete() {
    $tokenInfo = $this->verifyToken();

    $taskInfo = file_get_contents('php://input');
    $taskInfo = json_decode($taskInfo, true);

    $taskSet['end_time'] = $taskInfo['end_time'];

    $taskWhere['tid'] = $taskInfo['tid'];
    $taskWhere['pid'] = $tokenInfo['sub'];

    $task['set'] = $taskSet;
    $task['where'] = $taskWhere;

    $taskModel = new TaskModel('task', ['my_day', 'important']);
    $res['data']['msg'] = $taskModel->changeComp($task);

    $this->response($res, 204);
  }
}