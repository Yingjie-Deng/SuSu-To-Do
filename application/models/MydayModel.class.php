<?php

/**
 * Myday 视图模型
 * 
 */
class MydayModel extends Model {

  /**
   * 查询 Myday 下的任务
   * @access public
   * @return array $res 包含结果集的关联数组
   */
  public function getTasks() {
    $res = $this->db->getAll([
      'from' => "{$this->table}"
    ]);
    return $res;
  }
}