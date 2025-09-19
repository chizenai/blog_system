<?php
// api/index.php

// 设置响应头
// 替换原有的跨域头设置
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://localhost:5173"); // 仅允许前端域名
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true"); // 支持凭证（与前端withCredentials对应）
header("Access-Control-Max-Age: 86400"); // 预检请求缓存时间

// 处理预检请求
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// 根据请求的 URL 路由到相应的 API
$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// 解析请求路径
$path = parse_url($request_uri, PHP_URL_PATH);
$path_parts = explode('/', trim($path, '/'));

// 确定请求的资源类型
$resource = isset($path_parts[1]) ? $path_parts[1] : '';

// 根据资源类型和方法路由到相应的处理文件
switch ($resource) {
    case 'posts':
        require __DIR__ . '/posts.php';
        break;
    case 'categories':
        require __DIR__ . '/categories.php';
        break;
    default:
        // 404 Not Found
        http_response_code(404);
        echo json_encode(array("message" => "资源未找到。"));
        break;
}
