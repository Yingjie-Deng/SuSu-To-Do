<?php

/**
 * 昨天模型
 */
class TodayModel extends Model {

  /**
   * 查询记录
   * @param array
   */
  public function getToday($list) {
    return $this->db->getAll($list);
  }
}