<?php

/**
 * 昨天模型
 */
class YesterdayModel extends Model {

  /**
   * 查询记录
   * @param array
   */
  public function getYesterday($list) {
    return $this->db->getAll($list);
  }
}