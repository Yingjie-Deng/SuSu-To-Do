<?php

/**
 * 注册用，用于事务处理
 */
class PersonModel extends Model {

  /**
   * 构造 SQL 语句
   * @access private
   * @param array and string  $list 存有信息的关联数组，$table 待插入的表
   * @return string $sql 拼接后的 SQL 语句
   */
  private function concat($list, $table) {
    $field_list = '';
    $value_list = '';

    // 构造字段和相应的值
    foreach ($list as $k => $v) {
      $field_list .= "`$k` ,";
      $value_list .= "'$v' ,"; 
    }

    // 去除右边多余的逗号
    $field_list = rtrim($field_list, ',');
    $value_list = rtrim($value_list, ',');
    
    // 拼接SQL语句
    $sql = "INSERT INTO `{$table}`({$field_list}) VALUES ({$value_list})";

    // $str = $sql . '[' . date("Y-m-d H:i:s") . ']' . PHP_EOL;
    // file_put_contents('log.txt', $str, FILE_APPEND);
    return $sql;
  }

  /**
   * 插入记录
   * @access public
   * @param array and string  $list 存有信息的关联数组，$table 待插入的表
   * @return boolean 成功返回 true 失败返回 false
   */
  public function insert_new($list, $table) {
    return $this->db->oriQuery($this->concat($list, $table));
  }

  /**
   * 开启事务
   * @access public
   * 
   */
  public function begin() {
    $this->db->oriQuery('BEGIN');
  }

  /**
   * 提交事务
   * @access public
   */
  public function commit() {
    $this->db->oriQuery('COMMIT');
  }

  /**
   * 事务回滚
   * @access public
   */
  public function back() {
    $this->db->oriQuery('ROLLBACK');
  }

  /**
   * 结束事务
   * @access public
   */
  public function end() {
    $this->db->oriQuery('END');
  }

  /**
   * 关闭数据库
   * @access public
   * @return boolean
   */
  public function close() {
    return $this->db->close();
  }
}