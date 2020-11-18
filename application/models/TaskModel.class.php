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
}