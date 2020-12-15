<?php

/**
 * Overdue 模型
 */
class OverdueModel extends Model {

  /**s
   * 获取记录
   */
  public function getOverdue($list) {
    return $this->db->getAll($list);
  }
}