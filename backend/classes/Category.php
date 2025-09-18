<?php
// classes/Category.php

require_once 'config/database.php';

class Category {
    private $conn;
    private $table_name = "categories";
    
    // 对象属性
    public $id;
    public $name;
    public $description;
    public $created_at;
    
    // 构造函数
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // 读取分类列表
    public function read() {
        // 查询语句
        $query = "SELECT id, name, description, created_at 
                  FROM " . $this->table_name . " ORDER BY created_at DESC";
        
        // 准备语句
        $stmt = $this->conn->prepare($query);
        
        // 执行语句
        $stmt->execute();
        
        return $stmt;
    }
    
    // 读取单个分类
    public function readOne() {
        // 查询语句
        $query = "SELECT id, name, description, created_at 
                  FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        
        // 准备语句
        $stmt = $this->conn->prepare($query);
        
        // 绑定ID变量
        $stmt->bindParam(1, $this->id);
        
        // 执行语句
        $stmt->execute();
        
        // 获取行数据
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // 设置属性值
        $this->name = $row['name'];
        $this->description = $row['description'];
    }
    
    // 创建新分类
    public function create() {
        // 查询语句
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name = :name, description = :description";
        
        // 准备语句
        $stmt = $this->conn->prepare($query);
        
        // 清理数据
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        
        // 绑定数据
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        
        // 执行语句
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // 更新分类
    public function update() {
        // 查询语句
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, description = :description WHERE id = :id";
        
        // 准备语句
        $stmt = $this->conn->prepare($query);
        
        // 清理数据
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // 绑定数据
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":id", $this->id);
        
        // 执行语句
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // 删除分类
    public function delete() {
        // 查询语句
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        // 准备语句
        $stmt = $this->conn->prepare($query);
        
        // 清理数据
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // 绑定ID变量
        $stmt->bindParam(1, $this->id);
        
        // 执行语句
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}