<?php
require_once '../libs/RequestManager.php';

if (!isset($_GET['user_id']) || !isset($_GET['question_id']) || !isset($_GET['answer_choice']) || !isset($_GET['answer_time'])) {
    $json = ['status' => 'E00', 'msg' => 'REQUIRED_PARAM'];
} else {
    $data = RequestManager::addAnswer($_GET['user_id'], $_GET['question_id'], $_GET['answer_choice'], $_GET['answer_time']);
    if (!$data) {
        $json = ['status' => 'E00', 'msg' => 'FOREIGN_KEY_ERROR'];
    } else {
        $json = ['status' => 'S00', 'data' => ['user_id' => $data]];
    }
}

header("Content-Type: application/json; charset=utf-8");
echo json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);