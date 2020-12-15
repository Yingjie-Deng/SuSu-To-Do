<?php

/**
 * 直接登录模型类
 */
class DirectModel extends Model {
  /**
   * 查询密码
   * @access public
   * @param string $pid
   * @return string password
   */
  public function getPasw($pid) {
    return $this->db->getRow([
      'select' => "`password`",
      'from' => "`{$this->table}`"
    ])['password'];
  }
}