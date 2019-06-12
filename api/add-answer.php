<?php
require_once '../libs/RequestManager.php';

if (!isset($_POST['user_id']) || !isset($_POST['question_id']) || !isset($_POST['answer_choice']) || !isset($_POST['answer_time'])) {
    $json = ['status' => 'E00', 'msg' => 'REQUIRED_PARAM'];
} else {
    $data = RequestManager::addAnswer($_POST['user_id'], $_POST['question_id'], $_POST['answer_choice'], $_POST['answer_time']);
    if (!$data) {
        $json = ['status' => 'E00', 'msg' => 'FOREIGN_KEY_ERROR'];
    } else {
        $json = ['status' => 'S00', 'data' => ['user_id' => $data]];
    }
}

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=utf-8");
echo json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);