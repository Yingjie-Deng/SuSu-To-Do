<?php

/**
 * Comp 模型
 */
class CompModel extends Model {

  /**
   * 获取记录
   */
  public function getComp($list) {
    return $this->db->getAll($list);
  }
}