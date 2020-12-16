<?php

/**
 * Myday 视图模型
 * 
 */
class MydayModel extends Model {

  /**
   * 查询 Myday 下的任务
   * @access public
   * @param string $pid
   * @return array $res 包含结果集的关联数组
   */
  public function getTasks($pid) {
    $res = $this->db->getAll([
      'from' => "{$this->table}",
      'where' => "`pid`='{$pid}'"
    ]);
    return $res;
  }
}