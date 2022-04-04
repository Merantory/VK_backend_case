<?php

class commentsDataBaseRepository {

    /**
     * Сохранение отзыва
     * @param comment $comment Объект-отзыв, который сохраняем
     */
    static public function saveComment(comment $comment) {
        if ($comment->getID() === NULL) {
            self::createComment($comment);
        }
        else {
            self::updateComment($comment);
        }
    }

    static public function getLastID() {
        return DataBaseRepository::$database->last_insert_id();
    }

    /**
     * Создание отзыва в репозитории
     * @param comment $comment Объект-отзыв, который создаем
     */
    static private function createComment(comment $comment) {
        $username = ($comment->getUser()->isAnonym()) ? NULL : $comment->getUser()->getUsername();
        DataBaseRepository::$database->injection("INSERT INTO `comments`(number,user,description,rate) VALUES (?,?,?,?)",
            'sssi', $comment->getPhoneNumber()->getNumber(), $username, $comment->getDescription(), $comment->getRate());
        $comment->setID(self::getLastID());
    }

    /**
     * Обновление отзыва в репозитории
     * @param comment $comment Объект-отзыв, который обновляем
     */
    static private function updateComment(comment $comment) {
        $username = ($comment->getUser()->isAnonym()) ? NULL : $comment->getUser()->getUsername();
        DataBaseRepository::$database->injection("UPDATE `comments` SET number=?,user=?,description=?,rate=? WHERE id=?",
            'sssii',$comment->getPhoneNumber()->getNumber(), $username, $comment->getDescription(), $comment->getRate(),$comment->getID());
    }


    /**
     * Получение отзыва по его идентификатору
     * @param integer $id Идентификатор отзыва
     * @return comment Объект-отзыв соответствующий идентификатору
     */
    static public function getCommentByID($id) {
        $response = DataBaseRepository::$database->injection("SELECT comments.id, comments.number, comments.user, comments.description, comments.rate, users.token
        FROM `comments` LEFT JOIN users ON users.name = comments.user WHERE comments.id=?",'i',$id)->fetch_assoc();
        $comment_obj = new comment(new phoneNumber($response['number']), $response['description'], new user($response['token'],$response['user']),$response['rate']);
        $comment_obj->setID($id);
        return $comment_obj;
    }

    /**
     * Получение массива объектов-отзывов, которые относятся к определенному номеру телефона
     * @param phoneNumber $phoneNumber Объект-номер, к которому относятся отзывы
     * @return array Объекты-отзывы
     */
    static public function getCommentsByNumber(phoneNumber $phoneNumber) {
        $number = $phoneNumber->getNumber();
        $comments = DataBaseRepository::$database->injection("SELECT comments.id, comments.number, comments.user, comments.description, comments.rate, users.token
        FROM `comments` LEFT JOIN users ON users.name = comments.user WHERE number=?", 's', $number)->fetch_all(MYSQLI_ASSOC);
        $comments_objects = [];
        foreach ($comments as $value) {
            $obj = new comment(new phoneNumber($value['number']), $value['description'], new user($value['token'],$value['user']), $value['rate']);
            $obj->setID($value['id']);
            $comments_objects[] = $obj;
        }
        return $comments_objects;
    }
}