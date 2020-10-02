<?php

/**
 * 数据库操作类
 * framework/database/Mysal.class.php
 */
class Mysql
{
    protected $conn = null;   // 连接状态
    protected $sql;           // sql 语句

    /**
     * 构造函数，连接数据库并设置字符集。
     * @param $config String array
     *
     */
    public function __construct($config = array())
    {
        $host = isset($config['host']) ? $config['host'] : 'localhost';
        $user = isset($config['user']) ? $config['user'] : 'root';
        $password = isset($config['password']) ? $config['password'] : '';
        $dbname = isset($config['dbname']) ? $config['dbname'] : 'todo';
        $port = isset($config['port']) ? $config['port'] : '3306';
        $charset = isset($config['charset']) ? $config['charset'] : 'utf8';

        $this->conn = mysqli_connect($host, $user, $password, $dbname, $port) or false;
        if (!$this->conn) {
            $res = $GLOBALS['config']['res'];
            $res['meta']['msg'] = 'Database connected error';
            $res['meta']['status'] = 500;
            echo json_encode($res);
            exit();
        }
        $this->setChar($charset);
    }

    /**
     * Set charset
     * @access private
     * @param $charset String charset
     */
    private function setChar($charset)
    {
        $sql = 'set names ' . $charset;
        $this->query($sql);
    }

    /**
     * 执行 SQL语句
     * @access public
     * @param $sql String | String array  SQL query statement
     * @return $result, 如果成功，返回结果集；失败，返回错误信息
     */
    public function query($sql)
    {
        if (is_array($sql)) {
            // $select = isset($sql['select']) ? $sql['select'] : '*';
            // $from = isset($sql['from']) ? $sql['from'] : 'task';
            // $where = isset($sql['where']) ? $sql['where'] : '1';
            isset($sql['select']) ? '' : $sql['select'] = '*';
            isset($sql['from']) ? '' : $sql['from'] = 'task';

            $this->sql = sprintf("SELECT %s FROM %s ", $sql['select'], $sql['from']);
            isset($sql['where']) ? $this->sql = $this->sql . sprintf("WHERE %s ", $sql['where']) : '';
            isset($sql['group']) ? $this->sql = $this->sql . sprintf("GROUP BY %s ", $sql['group']) : '';
            isset($sql['having']) ? $this->sql = $this->sql . sprintf("HAVING %s ", $sql['having']) : '';
            isset($sql['order']) ? $this->sql = $this->sql . sprintf("ORDER BY %s ", $sql['order']) : '';
            isset($sql['limit']) ? $this->sql = $this->sql . sprintf("LIMIT %s", $sql['limit']) : '';
        } else {
            $this->sql = $sql;
        }
        $str = $this->sql . '[' . date("Y-m-d H:i:s") . ']' . PHP_EOL;
        file_put_contents('log.txt', $str, FILE_APPEND);
        $result = mysqli_query($this->conn, $this->sql);
        if (!$result) {
            $res = $GLOBALS['config']['res'];
            $res['meta']['msg'] = $this->errno() . ':' . $this->error() . 'Error SQL statement is:' . $this->sql;
            $res['meta']['status'] = 500;
            echo json_encode($res);
            exit();
        }
        echo $this->sql . '<br>';
        return $result;
    }

    /**
     * 获取一条记录
     * @access public
     * @param $sql sql语句
     * @return array associative array
     */
    public function getRow($sql)
    {
        if ($result = $this->query($sql)) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return false;
        }
    }

    /**
     * 获取所有的记录
     * @access public
     * @param $sql SQL语句
     * @return $list 一个包含结果集的二维数组
     */
    public function getAll($sql)
    {
        $result = $this->query($sql);
        $list = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $list[] = $row;
        }
        return $list;
    }

    /**
     * 获取错误代码
     * @access private
     * @return error number
     */
    private function errno() {
      return mysqli_errno($this->conn);
    }
    /**
     * 获取错误信息
     * @access private
     * @return error message
     */
    private function error() {
      return mysqli_error($this->conn);
    }
}
