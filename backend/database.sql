-- 创建数据库
CREATE DATABASE IF NOT EXISTS blog DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

-- 使用数据库
USE blog;

-- 创建文章表
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 创建分类表
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 插入一些示例数据
INSERT INTO categories (name, description) VALUES
('技术', '关于各种技术的文章'),
('生活', '日常生活中的分享'),
('教程', '各种教程和指南');

INSERT INTO posts (title, content) VALUES
('Vue.js 入门教程', 'Vue.js 是一个用于构建用户界面的渐进式框架。与其它大型框架不同的是，Vue 被设计为可以自底向上逐层应用。Vue 的核心库只关注视图层，不仅易于上手，还便于与第三方库或既有项目整合。'),
('PHP 开发指南', 'PHP 是一种广泛使用的服务器端脚本语言，特别适合 Web 开发。它可以嵌入 HTML 中使用，也可以用于命令行脚本和桌面应用程序。'),
('MySQL 数据库基础', 'MySQL 是世界上最受欢迎的开源数据库系统之一。它是一个关系型数据库管理系统，使用 SQL 进行数据库操作。');
