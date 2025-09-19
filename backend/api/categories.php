<?php
// api/categories.php

// 设置响应头
header("Access-Control-Allow-Origin: http://blog");
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// 调试信息
error_log("请求方法: " . $_SERVER['REQUEST_METHOD']);
error_log("请求头: " . json_encode(getallheaders()));

// 处理预检请求
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// 引入必要的文件
require_once '../config/database.php';
require_once '../classes/Category.php';

// 创建数据库连接
$conn = getDbConnection();

// 创建分类对象
$category = new Category($conn);

// 根据请求方法处理不同的操作
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // 获取查询参数
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($id) {
            // 获取单个分类
            $category->id = $id;
            $stmt = $category->readOne();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);

                // 创建分类数组
                $category_arr = array(
                    "id" => $id,
                    "name" => $name,
                    "created_at" => $created_at
                );

                // 将分类数组转换为JSON并输出
                http_response_code(200);
                echo json_encode($category_arr);
            } else {
                // 未找到分类
                http_response_code(404);
                echo json_encode(array("message" => "未找到分类。"));
            }
        } else {
            // 获取分类列表
            $stmt = $category->read();
            $num = $stmt->rowCount();

            if ($num > 0) {
                $categories_arr = array();
                $categories_arr["records"] = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $category_item = array(
                        "id" => $id,
                        "name" => $name,
                        "created_at" => $created_at
                    );
                    array_push($categories_arr["records"], $category_item);
                }

                // 设置响应代码 - 200 OK
                http_response_code(200);

                // 输出分类列表
                echo json_encode($categories_arr);
            } else {
                // 设置响应代码 - 404 Not found
                http_response_code(404);

                // 告诉用户没有分类
                echo json_encode(array("message" => "未找到任何分类。"));
            }
        }
        break;

    case 'POST':
        // 获取POST数据
        $json_data = file_get_contents("php://input");
$data = json_decode($json_data);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(array("message" => "无效的 JSON 格式"));
    exit;
}

        // 确保数据不为空
        if (!empty($data->name)) {
            // 设置分类属性
            $category->name = $data->name;

            // 创建分类
            if ($category->create()) {
                // 设置响应代码 - 201 Created
                http_response_code(201);

                // 告诉用户分类已创建
                echo json_encode(array("message" => "分类已创建。"));
            } else {
                // 设置响应代码 - 503 Service unavailable
                http_response_code(503);

                // 告诉用户无法创建分类
                echo json_encode(array("message" => "无法创建分类。"));
            }
        } else {
            // 设置响应代码 - 400 Bad request
            http_response_code(400);

            // 告诉用户数据不完整
            echo json_encode(array("message" => "数据不完整，无法创建分类。"));
        }
        break;

    case 'PUT':
        // 获取PUT数据
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(array("message" => "无效的 JSON 格式"));
            exit;
        }

        // 确保数据不为空且有ID
        if (!empty($data->id) && !empty($data->name)) {
            // 设置分类属性
            $category->id = $data->id;
            $category->name = $data->name;

            // 更新分类
            if ($category->update()) {
                // 设置响应代码 - 200 OK
                http_response_code(200);

                // 告诉用户分类已更新
                echo json_encode(array("message" => "分类已更新。"));
            } else {
                // 设置响应代码 - 503 Service unavailable
                http_response_code(503);

                // 告诉用户无法更新分类
                echo json_encode(array("message" => "无法更新分类。"));
            }
        } else {
            // 设置响应代码 - 400 Bad request
            http_response_code(400);

            // 告诉用户数据不完整
            echo json_encode(array("message" => "数据不完整，无法更新分类。"));
        }
        break;

    case 'DELETE':
        // 获取ID
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(array("message" => "无效的 JSON 格式"));
            exit;
        }

        // 确保有ID
        if (!empty($data->id)) {
            // 设置分类ID
            $category->id = $data->id;

            // 删除分类
            if ($category->delete()) {
                // 设置响应代码 - 200 OK
                http_response_code(200);

                // 告诉用户分类已删除
                echo json_encode(array("message" => "分类已删除。"));
            } else {
                // 设置响应代码 - 503 Service unavailable
                http_response_code(503);

                // 告诉用户无法删除分类
                echo json_encode(array("message" => "无法删除分类。"));
            }
        } else {
            // 设置响应代码 - 400 Bad request
            http_response_code(400);

            // 告诉用户数据不完整
            echo json_encode(array("message" => "数据不完整，无法删除分类。"));
        }
        break;

    default:
        // 请求方法不允许
        http_response_code(405);
        header('Content-Type: application/json; charset=utf-8');
$message = array("message" => "请求方法不允许。");
$json_response = json_encode($message);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo json_encode(array("message" => "JSON 编码失败"));
    exit;
}

echo $json_response;
        break;
}
