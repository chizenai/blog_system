<?php
// api/index.php

// 设置响应头
// 替换原有的跨域头设置
header_remove("Access-Control-Allow-Origin");
header_remove("Access-Control-Allow-Methods");
header_remove("Access-Control-Allow-Headers");
header_remove("Access-Control-Allow-Credentials");
header_remove("Access-Control-Max-Age");

// 设置响应头
header("Content-Type: application/json; charset=UTF-8");

// 根据请求来源设置适当的CORS头
$origin = isset($_SERVER["HTTP_ORIGIN"]) ? $_SERVER["HTTP_ORIGIN"] : "";

// 允许的域名列表
$allowed_origins = [
    "http://blog",
    "http://www.blog",
    "https://blog",
    "https://www.blog",
    "http://blog:80",
    "http://www.blog:80",
    "https://blog:443",
    "https://www.blog:443",
    "http://localhost:5173"
];

// 标志，跟踪是否已经设置了CORS头
$cors_headers_set = false;

// 检查请求来源是否在允许列表中
if (in_array($origin, $allowed_origins) && !$cors_headers_set) {
    // 只设置一次Access-Control-Allow-Origin头
    header("Access-Control-Allow-Origin: " . $origin);
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 86400");
    $cors_headers_set = true;
}

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