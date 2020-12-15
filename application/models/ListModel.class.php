<?php

/**
 * 任务清单类
 */
class ListModel extends Model {

  /**
   * 加载用户的清单
   * @access public
   * @param string $pid
   * @return array
   */
  public function loadList($pid) {
    return $this->db->getAll([
      'select' => "`lid`, `name` AS `listName`",
      'from' => "{$this->table}",
      'where' => "`pid`='{$pid}'"
    ]);
  }
  /**
   * 添加用户清单
   * @access public
   * @param array $list
   * @return 
   */
  public function addList($list) {
    $this->insert($list);
    return 'OK';
  }
  /**
   * 添加用户清单
   * @access public
   * @param array $list
   * @return 
   */
  public function rename($list) {
    $this->update($list);
    return 'OK';
  }
  /**
   * 添加用户清单
   * @access public
   * @param array $list
   * @return 
   */
  public function remove($list) {
    $this->delete($list);
    return 'OK';
  }
  
}