<?php

/**
 * 重要 模型
 */
class ImptModel extends Model {

  /**
   * 获取记录
   * @access public
   * @param array
   */
  public function get($list) {
    return $this->db->getAll($list);
  }
}