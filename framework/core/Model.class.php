<?php

/**
 * 基础模型类
 * framework/core/Model.class.php
 */
class Model {
  protected $db;    // 数据库连接对象
  protected $table;     // 表名或视图名
  protected $original;    // 保留原始值，不要加引号

  public function __construct($table, $ori = array()) {
    $dbconfig = $GLOBALS['config']['db'];
    $this->db = new Mysql($dbconfig);
    $this->table = $table;
    $this->original = $ori;
  }

  /**
   * 预处理待插入数据
   * @access public
   * @param $list 关联数组，通过引用传递
   */
  public function preprocess(&$list) {
    foreach ($list as $k => $v) {
      if (!in_array($k, $this->original)) {
        $list[$k] = "'$v'";
      }
    }
  }

  /**
   * 插入记录
   * @access public
   * @param array $list 关联数组
   * @return 插入成功返回true，失败结束脚本 
   */
  public function insert($list) {
    // 对数据进行预处理，为字符串、时间等类型加上引号
    // foreach ($list as $k => $v) {
    //   if (!in_array($k, $this->original)) {
    //     $list[$k] = "'$v'";
    //   }
    // }
    $this->preprocess($list);

    $field_list = '';
    $value_list = '';

    // 构造字段和相应的值
    foreach ($list as $k => $v) {
      $field_list .= "`$k` ,";
      $value_list .= "$v ,"; 
    }

    // 去除右边多余的逗号
    $field_list = rtrim($field_list, ',');
    $value_list = rtrim($value_list, ',');
    
    // 拼接SQL语句
    $sql = "INSERT INTO `{$this->table}`({$field_list}) VALUES ({$value_list})";
    return $this->db->query($sql);
  }

  /**
   * 修改记录
   * @access public
   * @param $list 关联数组，内含两个关联数组，保存更新结果和更新条件
   * @return 内部调用query方法，返回值同query，成功返回true，失败结束脚本
   */
  public function update($list) {
    // $list = [
    //   'set' => ['associative' => 'new values'],
    //   'where' => ['associative' => 'condition']
    // ];
      $this->preprocess($list['set']);
      $this->preprocess($list['where']);
      $set_list = '';
      $where_list = false;    // 布尔值 false 转字符串为空
      foreach ($list['set'] as $k => $v) {
        $set_list .= "`$k`=$v,";
      }
      foreach ($list['where'] as $k => $v) {
        $where_list .= "`$k`=$v AND ";
      }
      $set_list = rtrim($set_list, ',');
      $where_list = rtrim($where_list, ' AND ');

      $sql = "UPDATE `{$this->table}` SET {$set_list} WHERE {$where_list}";
      return $this->db->query($sql);
  }

  /**
   * 删除记录
   * @access public
   * @param $list 关联数组，提供删除条件
   * @return 成功返回true（1） 失败结束脚本
   */
  public function delete($list) {
    // $list = [
    //   'assco' => 'condition',
    //    ...
    // ];
    $this->preprocess($list);
    $where_list = false;
    foreach ($list as $k => $v) {
      $where_list .= "`{$k}`=$v AND ";
    }
    $where_list = rtrim($where_list, ' AND ');
    $sql = "DELETE FROM `{$this->table}` WHERE {$where_list}";
    return $this->db->query($sql);
  }
}