<?php

/**
 * 用户信息模型，建立在视图personInfo上
 */
class PInfoModel extends Model {

  /**
   * 获取用户信息
   * @access public
   * @param string $pid
   * @return array $result 结果集
   */
  public function getInfo($pid) {
    return $this->db->getRow([
      'from' => "{$this->table}",
      'where' => "`pid`='{$pid}'",
      'order' => '`login_name` DESC'
    ]);
  }
}