<?php
// config/database.php

// 数据库配置
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // 您的数据库用户名
define('DB_PASS', 'root');     // 您的数据库密码
define('DB_NAME', 'blog'); // 数据库名

// 创建数据库连接
function getDbConnection() {
    try {
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
        // 设置错误模式为异常
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "连接失败: " . $e->getMessage();
        return null;
    }
}
