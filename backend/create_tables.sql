-- 创建分类表
CREATE TABLE IF NOT EXISTS categories (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 创建文章表
CREATE TABLE IF NOT EXISTS posts (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT,
  category_id INT(11),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 插入一些示例分类
INSERT INTO categories (name) VALUES ('技术'), ('生活'), ('旅行') ON DUPLICATE KEY UPDATE name=name;

-- 插入一些示例文章
INSERT INTO posts (title, content, category_id) VALUES 
('欢迎使用博客系统', '这是一个使用 Vue.js 和 PHP 构建的博客系统。您可以通过这个系统发布和管理文章。', 1),
('如何开始使用 Vue.js', 'Vue.js 是一个用于构建用户界面的渐进式框架。它易于学习，同时非常强大，可以处理复杂的单页应用。', 1),
('周末旅行计划', '这个周末计划去郊外徒步，享受大自然的美好。已经准备好了所有装备，期待这次旅行。', 3),
('健康生活的秘诀', '保持健康的生活方式包括均衡的饮食、适量的运动和充足的睡眠。这些习惯可以帮助我们保持身心健康。', 2)
ON DUPLICATE KEY UPDATE title=title, content=content, category_id=category_id;
