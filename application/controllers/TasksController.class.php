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
    $res['data']['myday_tasks'] = $mydayModel->getTasks($tokenInfo['sub']);
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

  /**
   * 查询‘重要’的记录
   * @access public
   */
  public function getImpt() {
    $tokenInfo = $this->verifyToken();

    $list['from'] = "important";
    $list['where'] = "`pid`='{$tokenInfo['sub']}'";
    $imptModel = new ImptModel('important');
    $res['data']['tasks'] = $imptModel->get($list);

    $this->response($res);
  }

  /**
   * 查询‘昨天-今天-明天’的记录
   */
  public function getPpf() {
    $tokenInfo = $this->verifyToken();

    $yList['from'] = "yesterday";
    $yList['where'] = "`pid`='{$tokenInfo['sub']}'";

    $tList['from'] = "today";
    $tList['where'] = "`pid`='{$tokenInfo['sub']}'";

    $tomorrowList['from'] = "mystery";
    $tomorrowList['where'] = "`pid`='{$tokenInfo['sub']}'";

    $yModel = new YesterdayModel('yesterday');
    $res['data']['yTasks'] = $yModel->getYesterday($yList);

    $todayModel = new TodayModel('mystery');
    $res['data']['todayTasks'] = $todayModel->getToday($tList);

    $tomorrowModel = new TomorrowModel('today');
    $res['data']['tomorrowTasks'] = $tomorrowModel->getTomorrow($tomorrowList);

    $this->response($res);
  }

  /**
   * 查询‘全部’的记录
   * @access public
   */
  public function getAll() {
    $tokenInfo = $this->verifyToken();

    $list['from'] = "`all`";
    $list['where'] = "`pid`='{$tokenInfo['sub']}'";
    $allModel = new AllModel('all');
    $tasks = $allModel->getAll($list);
    $arr = [];

    foreach ($tasks as $key => $value) {
      if ($value['end_time'] == '0000-00-00 00:00:00') {
        $value['complete'] = false;
      } else {
        $value['complete'] = true;
      }
      if ($value['import'] == '0') {
        $value['import'] = false;
      } else {
        $value['import'] = true;
      }
      $arr[$value['listName']][] = $value;
    }
    foreach ($arr as $key => $value) {
      $temp = ['tasks' => $value, 'count' => count($value), 'isfold' => false];
      $arr[$key] =$temp;
    }
    $res['data']['tasks'] = $arr;
    $this->response($res);
  }

  /**
   * 查询‘已完成’的记录
   * @access public
   */
  public function getComplete() {
    $tokenInfo = $this->verifyToken();

    $list['from'] = "`completed`";
    $list['where'] = "`pid`='{$tokenInfo['sub']}'";
    $allModel = new CompModel('completed');
    $tasks = $allModel->getComp($list);
    $arr = [];

    foreach ($tasks as $key => $value) {
      if ($value['end_time'] == '0000-00-00 00:00:00') {
        $value['complete'] = false;
      } else {
        $value['complete'] = true;
      }
      if ($value['import'] == '0') {
        $value['import'] = false;
      } else {
        $value['import'] = true;
      }
      $arr[$value['listName']][] = $value;
    }
    foreach ($arr as $key => $value) {
      $temp = ['tasks' => $value, 'count' => count($value), 'isfold' => false];
      $arr[$key] =$temp;
    }
    $res['data']['tasks'] = $arr;
    $this->response($res);
  }

  /**
   * 查询‘逾期未完成’的记录
   * @access public
   */
  public function getOverdue() {
    $tokenInfo = $this->verifyToken();

    $list['from'] = "`overdue`";
    $list['where'] = "`pid`='{$tokenInfo['sub']}'";
    $allModel = new OverdueModel('overdue');
    $tasks = $allModel->getOverdue($list);
    $arr = [];

    foreach ($tasks as $key => $value) {
      if ($value['end_time'] == '0000-00-00 00:00:00') {
        $value['complete'] = false;
      } else {
        $value['complete'] = true;
      }
      if ($value['import'] == '0') {
        $value['import'] = false;
      } else {
        $value['import'] = true;
      }
      $arr[$value['listName']][] = $value;
    }
    foreach ($arr as $key => $value) {
      $temp = ['tasks' => $value, 'count' => count($value), 'isfold' => false];
      $arr[$key] =$temp;
    }
    $res['data']['tasks'] = $arr;
    $this->response($res);
  }

  /**
   * 查询各个清单的记录
   * @access public
   */
  public function listShow() {
    $tokenInfo = $this->verifyToken();

    $requ = $_GET;
    $requ['pid'] = $tokenInfo['sub'];

    $taskModel = new TaskModel('task', ['my_day', 'important']);
    $total = $taskModel->getTotal($requ);
    $tasks = $taskModel->getTasksByLid($requ);
    $res['data']['total'] = $total;
    $res['data']['tasks'] = $tasks;

    $this->response($res);
  }

  /**
   * 查询任务的详细信息
   * @access public
   */
  public function detail() {
    $tokenInfo = $this->verifyToken();

    $tid = $_GET['tid'];

    $taskModel = new TaskModel('task', ['my_day', 'important']);
    $res['data']['detail'] = $taskModel->getDetail($tid, $tokenInfo['sub']);

    $this->response($res);
  }

  /**
   * 搜索 task 表中符合用户给定的条件的 item
   * @access public
   */
  public function search() {
    $tokenInfo = $this->verifyToken();

    $query = $_GET;
    $query['pid'] = $tokenInfo['sub'];

    $taskModel = new TaskModel('task', ['my_day', 'important']);
    $res['data']['tasks'] = $taskModel->getSearchResult($query);

    $this->response($res);
  }
}