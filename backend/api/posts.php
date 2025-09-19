<?php
// api/posts.php

// 设置响应头
// CORS头部已在index.php中设置，此处不再重复设置

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
require_once '../classes/Post.php';

// 创建数据库连接
$conn = getDbConnection();

// 创建文章对象
$post = new Post($conn);

// 根据请求方法处理不同的操作
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // 获取查询参数
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($id) {
            // 获取单篇文章
            $post->id = $id;
            $stmt = $post->readOne();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);

                // 创建文章数组
                $post_arr = array(
                    "id" => $id,
                    "title" => $title,
                    "content" => $content,
                    "created_at" => $created_at,
                    "updated_at" => $updated_at
                );

                // 将文章数组转换为JSON并输出
                http_response_code(200);
                $json_response = json_encode($post_arr);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    http_response_code(500);
                    echo json_encode(array("message" => "JSON 编码失败"));
                    exit;
                }
                echo $json_response;
            } else {
                // 未找到文章
                http_response_code(404);
                $json_response = json_encode(array("message" => "未找到任何文章。"));
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo json_encode(array("message" => "JSON 编码失败"));
    exit;
}
echo $json_response;
            }
        } else {
            // 获取文章列表
            $stmt = $post->read();
            $num = $stmt->rowCount();

            if ($num > 0) {
                $posts_arr = array();
                $posts_arr["records"] = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $post_item = array(
                        "id" => $id,
                        "title" => $title,
                        "content" => $content,
                        "created_at" => $created_at,
                        "updated_at" => $updated_at
                    );
                    array_push($posts_arr["records"], $post_item);
                }

                // 设置响应代码 - 200 OK
                http_response_code(200);

                // 输出文章列表
                $json_response = json_encode($posts_arr);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    http_response_code(500);
                    echo json_encode(array("message" => "JSON 编码失败"));
                    exit;
                }
                echo $json_response;
            } else {
                // 设置响应代码 - 404 Not found
                http_response_code(404);

                // 告诉用户没有文章
                $json_response = json_encode(array("message" => "未找到任何文章。"));
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo json_encode(array("message" => "JSON 编码失败"));
    exit;
}
echo $json_response;
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
        if (!empty($data->title) && !empty($data->content)) {
            // 设置文章属性
            $post->title = $data->title;
            $post->content = $data->content;

            // 创建文章
            if ($post->create()) {
                // 设置响应代码 - 201 Created
                http_response_code(201);

                // 告诉用户文章已创建
                $json_response = json_encode(array("message" => "文章已创建。"));
                if (json_last_error() !== JSON_ERROR_NONE) {
                    http_response_code(500);
                    echo json_encode(array("message" => "JSON 编码失败"));
                    exit;
                }
                echo $json_response;
            } else {
                // 设置响应代码 - 503 Service unavailable
                http_response_code(503);

                // 告诉用户无法创建文章
                $json_response = json_encode(array("message" => "无法创建文章。"));
                if (json_last_error() !== JSON_ERROR_NONE) {
                    http_response_code(500);
                    echo json_encode(array("message" => "JSON 编码失败"));
                    exit;
                }
                echo $json_response;
            }
        } else {
            // 设置响应代码 - 400 Bad request
            http_response_code(400);

            // 告诉用户数据不完整
            $json_response = json_encode(array("message" => "数据不完整，无法创建文章。"));
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo json_encode(array("message" => "JSON 编码失败"));
    exit;
}
echo $json_response;
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
        if (!empty($data->id) && !empty($data->title) && !empty($data->content)) {
            // 设置文章属性
            $post->id = $data->id;
            $post->title = $data->title;
            $post->content = $data->content;

            // 更新文章
            if ($post->update()) {
                // 设置响应代码 - 200 OK
                http_response_code(200);

                // 告诉用户文章已更新
                $json_response = json_encode(array("message" => "文章已更新。"));
                if (json_last_error() !== JSON_ERROR_NONE) {
                    http_response_code(500);
                    echo json_encode(array("message" => "JSON 编码失败"));
                    exit;
                }
                echo $json_response;
            } else {
                // 设置响应代码 - 503 Service unavailable
                http_response_code(503);

                // 告诉用户无法更新文章
                $json_response = json_encode(array("message" => "无法更新文章。"));
                if (json_last_error() !== JSON_ERROR_NONE) {
                    http_response_code(500);
                    echo json_encode(array("message" => "JSON 编码失败"));
                    exit;
                }
                echo $json_response;
            }
        } else {
            // 设置响应代码 - 400 Bad request
            http_response_code(400);

            // 告诉用户数据不完整
            echo json_encode(array("message" => "数据不完整，无法更新文章。"));
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
            // 设置文章ID
            $post->id = $data->id;

            // 删除文章
            if ($post->delete()) {
                // 设置响应代码 - 200 OK
                http_response_code(200);

                // 告诉用户文章已删除
                $json_response = json_encode(array("message" => "文章已删除。"));
                if (json_last_error() !== JSON_ERROR_NONE) {
                    http_response_code(500);
                    echo json_encode(array("message" => "JSON 编码失败"));
                    exit;
                }
                echo $json_response;
            } else {
                // 设置响应代码 - 503 Service unavailable
                http_response_code(503);

                // 告诉用户无法删除文章
                $json_response = json_encode(array("message" => "无法删除文章。"));
                if (json_last_error() !== JSON_ERROR_NONE) {
                    http_response_code(500);
                    echo json_encode(array("message" => "JSON 编码失败"));
                    exit;
                }
                echo $json_response;
            }
        } else {
            // 设置响应代码 - 400 Bad request
            http_response_code(400);

            // 告诉用户数据不完整
            echo json_encode(array("message" => "数据不完整，无法删除文章。"));
        }
        break;

    default:
        // 请求方法不允许
        http_response_code(405);
        $json_response = json_encode(array("message" => "请求方法不允许。"));
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(500);
            echo json_encode(array("message" => "JSON 编码失败"));
            exit;
        }
        echo $json_response;
        break;
}