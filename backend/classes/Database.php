<?php
// classes/Database.php

require_once '../config/database.php';

class Database {
    // 数据库连接
    public $conn;
    
    // 构造函数
    public function __construct() {
        $this->conn = getDbConnection();
    }
}
?>