<?php

/**
 * 任务类
 */
class TaskModel extends Model {

  /**
   * 添加一条记录
   * @access public
   * @param Array; $taskInfo
   * @return String
   */
  public function addOneTask($taskInfo) {
    $this->insert($taskInfo);
    return 'OK';
  }

  /**
   * 修改重要性
   * @access public
   * @param array $setAndWhere
   * @return string
   */
  public function changeImpt($setAndWhere) {
    $this->update($setAndWhere);
    return 'OK';
  }

  /**
   * 修改完成与否
   * @access public
   * @param array
   * @return string
   */
  public function changeComp($taskInfo) {
    $this->update($taskInfo);
    return 'OK';
  }

  /**
   * 查询清单对应的任务总数
   * @access public
   * @param array $requ
   * @return number
   */
  public function getTotal($requ) {
    return $this->db->getRow([
      'select' => 'count(*) AS total',
      'from' => "`{$this->table}`",
      'where' => "`lid`='{$requ['lid']}' AND `pid`='{$requ['pid']}'"
    ])['total'];
  }

  /**
   * 按清单 ID 分页查询任务记录
   * @access public
   * @param array $requ
   * @return array
   */
  public function getTasksByLid($requ) {
    $offset = $requ['pagesize'] * ($requ['pagenum'] - 1);
    $result = $this->db->getAll([
      'from' => "`{$this->table}`",
      'where' => "`pid`='{$requ['pid']}' AND `lid`='{$requ['lid']}'",
      'order' => "`end_time`, `found_time` DESC",
      'limit' => "{$requ['pagesize']} OFFSET {$offset}"
    ]);
    foreach ($result as $key => $value) {
      if ($result[$key]['end_time'] == '0000-00-00 00:00:00') {
        $result[$key]['complete'] = false;
      } else {
        $result[$key]['complete'] = true;
      }
      if ($result[$key]['important'] == '0') {
        $result[$key]['import'] = false;
      } else {
        $result[$key]['import'] = true;
      }
    }
    return $result;
  }

  /**
   * 查询单个任务的详细信息
   * @access public
   * @param string $tid
   * @return array
   */
  public function getDetail($tid, $pid) {
    $result = $this->db->getRow([
      'from' => "`{$this->table}`",
      'where' => "`pid`='{$pid}' AND `tid`='{$tid}'"
    ]);
    if ($result['end_time'] == '0000-00-00 00:00:00') {
      $result['complete'] = false;
    } else {
      $result['complete'] = true;
    }
    if ($result['my_day'] == '0') {
      $result['myday'] = false;
    } else {
      $result['myday'] = true;
    }
    if ($result['important'] == '0') {
      $result['import'] = false;
    } else {
      $result['import'] = true;
    }

    $steps = $this->db->getAll([
      'from' => "`{$this->table}`",
      'where' => "`tid`='{$tid}'"
    ]);
    foreach ($steps as $key => $value) {
      if ($steps[$key]['end_time']== '0000-00-00 00:00:00') {
        $steps[$key]['complete'] = false;
      } else {
        $steps[$key]['complete'] = true;
      }
    }

    $result['steps'] = $steps;
    return $result;
  }

  /**
   * 按用户给定信息查询符合条件的任务
   * @access public
   * @param array $query
   * @return array
   */
  public function getSearchResult($query) {
    $lid = '';
    if ($query['select']) {
      $lid = " AND `{$this->table}`.`lid`='{$query['select']}'";
    }
    $result = $this->db->getAll([
      'select' => "`{$this->table}`.*, `list`.`name` AS listName",
      'from' => "`{$this->table}` JOIN `list` ON `{$this->table}`.`lid`=`list`.`lid`",
      'where' => "`{$this->table}`.`pid`='{$query['pid']}' {$lid} AND `content` LIKE '%{$query['query']}%'"
    ]);
    foreach ($result as $key => $value) {
      if ($value['end_time'] == '0000-00-00 00:00:00') {
        $result[$key]['complete'] = false;
      } else {
        $result[$key]['complete'] = true;
      }
      if ($value['important'] == '0') {
        $result[$key]['import'] = false;
      } else {
        $result[$key]['import'] = true;
      }
    }
    
    return $result;
  }

  /**
   * 删除任务
   * @access public
   * @param string $tid
   */
  public function deleteTask($tid) {
    $this->delete([
      'tid' => "$tid"
    ]);
  }
}