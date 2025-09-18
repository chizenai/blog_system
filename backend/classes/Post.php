<?php
// classes/Post.php

require_once 'config/database.php';

class Post {
    private $conn;
    private $table_name = "posts";
    
    // 对象属性
    public $id;
    public $title;
    public $content;
    public $created_at;
    public $updated_at;
    
    // 构造函数
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // 读取文章列表
    public function read() {
        // 查询语句
        $query = "SELECT id, title, content, created_at, updated_at 
                  FROM " . $this->table_name . " ORDER BY created_at DESC";
        
        // 准备语句
        $stmt = $this->conn->prepare($query);
        
        // 执行语句
        $stmt->execute();
        
        return $stmt;
    }
    
    // 读取单篇文章
    public function readOne() {
        // 查询语句
        $query = "SELECT id, title, content, created_at, updated_at 
                  FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        
        // 准备语句
        $stmt = $this->conn->prepare($query);
        
        // 绑定ID变量
        $stmt->bindParam(1, $this->id);
        
        // 执行语句
        $stmt->execute();
        
        // 获取行
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // 设置属性值
        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->created_at = $row['created_at'];
        $this->updated_at = $row['updated_at'];
    }
    
    // 创建新文章
    public function create() {
        // 查询语句
        $query = "INSERT INTO " . $this->table_name . " 
                  SET title = :title, content = :content";
        
        // 准备语句
        $stmt = $this->conn->prepare($query);
        
        // 清理数据
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        
        // 绑定数据
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        
        // 执行语句
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // 更新文章
    public function update() {
        // 查询语句
        $query = "UPDATE " . $this->table_name . " 
                  SET title = :title, content = :content 
                  WHERE id = :id";
        
        // 准备语句
        $stmt = $this->conn->prepare($query);
        
        // 清理数据
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // 绑定数据
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":id", $this->id);
        
        // 执行语句
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // 删除文章
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
