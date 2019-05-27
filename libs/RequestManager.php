<?php
class RequestManager {
    /** DB更新取得
     * @param $last_update_date
     * @return null
     */
    public static function dbUpdate($last_update_date) {
        require_once 'DatabaseManager.php';
        $db = new DatabaseManager();
        $data = null;

        // answers_rate_db
        $sql = "SELECT * FROM answers_rate_db";
        $array = array();
        $data['answers_rate_db'] = $db->fetchAll($sql, $array);

        // answer_db
        $sql = "SELECT * FROM answer_db";
        $array = array();
        $data['answer_db'] = $db->fetchAll($sql, $array);

        // exams_numbers_db
        $sql = "SELECT * FROM exams_numbers_db";
        $array = array();
        $data['exams_numbers_db'] = $db->fetchAll($sql, $array);

        // exams_questions_db
        $sql = "SELECT * FROM exams_questions_db";
        $array = array();
        $data['exams_questions_db'] = $db->fetchAll($sql, $array);

        // genres_db
        $sql = "SELECT * FROM genres_db";
        $array = array();
        $data['genres_db'] = $db->fetchAll($sql, $array);

        // image_db
        $sql = "SELECT * FROM image_db";
        $array = array();
        $data['image_db'] = $db->fetchAll($sql, $array);

        // questions_db
        $sql = "SELECT * FROM questions_db WHERE update_date > :update_date";
        $array = array('update_date' => $last_update_date);
        $data['questions_db'] = $db->fetchAll($sql, $array);

        // questions_genres_db
        $sql = "SELECT * FROM questions_genres_db";
        $array = array();
        $data['questions_genres_db'] = $db->fetchAll($sql, $array);

        return $data;
    }

    /** ユーザー登録
     * @param $token
     * @return string
     */
    public static function addUser($token) {
        require_once 'DatabaseManager.php';
        $db = new DatabaseManager();
        require_once 'functions.php';

        do {
            $user_id = random(8);
            $count = $db->fetch("SELECT count(*) FROM users WHERE user_id = :user_id", array('user_id' => $user_id));
            if ($count != 0) {
                break;
            }
        } while (true);

        $sql = "INSERT INTO users(user_id, token) VALUES (:user_id, :token)";
        $array = array('user_id' => $user_id, 'token' => $token);
        $db->insert($sql, $array);

        return $user_id;
    }

    /** 統計情報取得
     * @return array
     */
    public static function getStatisticsInfo() {
        require_once 'DatabaseManager.php';
        $db = new DatabaseManager();
        $sql = "SELECT * FROM answers_rate_db";
        $data = $db->fetchAll($sql, array());
        return $data;
    }

    /** 解答履歴登録
     * @param $user_id
     * @param $question_id
     * @param $answer_choice
     * @param $answer_time
     * @return string
     */
    public static function addAnswer($user_id, $question_id, $answer_choice, $answer_time) {
        require_once 'DatabaseManager.php';
        $db = new DatabaseManager();
        $sql = "INSERT INTO all_user_answers(user_id, question_id, answer_choice, answer_time) VALUES (:user_id, :question_id, :answer_choice, :answer_time)";
        $array = array('user_id' => $user_id, 'question_id' => $question_id, 'answer_choice' => $answer_choice, 'answer_time' => $answer_time);
        $id = $db->insert($sql, $array);
        if (!$id) {
            return false;
        }
        return $id;
    }
}