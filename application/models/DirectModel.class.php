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
      'from' => "`{$this->table}`",
      'where' => "`pid`='{$pid}'"
    ])['password'];
  }

  /**
   * 查询数量
   * @access public
   * @param string $pid
   * @return int
   */
  public function count($pid) {
    return $this->db->getRow([
      'select' => "count(*) AS count",
      'from' => "`{$this->table}`",
      'where' => "`pid`='{$pid}' AND `login_name` LIKE '%@%'"
    ])['count'];
  }

  // /**
  //  * 插入一条登录信息
  //  * @access public
  //  * @param array
  //  */
  // public function insert($query) {
  //   $this->insert($query);
  // }

  /**
   * 字符串形式修改记录
   * @access public
   * @param string
   */
  public function strUpdate($sql) {
    $this->db->query($sql);
  }
}