<?php

/**
 * 昨天模型
 */
class TomorrowModel extends Model {

  /**
   * 查询记录
   * @param array
   */
  public function getTomorrow($list) {
    return $this->db->getAll($list);
  }
}