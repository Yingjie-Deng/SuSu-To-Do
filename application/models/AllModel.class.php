<?php

/**
 * all 模型
 */
class AllModel extends Model {

  /**
   * 获取记录
   */
  public function getAll($list) {
    return $this->db->getAll($list);
  }
}