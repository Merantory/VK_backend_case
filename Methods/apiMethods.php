<?php

class apiMethods {

    /** Вызываемый метод
     * @param string $methodName название метода
     * @param user $user Объект-пользователь
     * @param array $params Массив параметров
     * @return array Массив результата выполнения
     */
    static public function callMethod($methodName,user $user,array $params) {
        switch ($methodName) {
            case 'getCountryCode':
                return self::getCountryCode($params['number']);
            case 'createComment':
                return self::createComment($params['number'],$params['description'],$user);
            case 'getCommentsByNumber':
                return self::getCommentsByNumber($params['number']);
            case 'getNumbersByPattern':
                return self::getNumbersByPattern($params['pattern']);
            case 'addRate':
                return self::addRate($params['commentID'],$user);
            case 'downRate':
                return self::downRate($params['commentID'],$user);
        }
        return [];
    }

    static public function getCountryCode($number) {
        return ['country' => (new phoneNumber($number))->getCountryCode()];
    }


    /** Создание отзыва
     * @param string $number Номер, о котором создается отзыв
     * @param string $description Описание отзыва
     * @param user $user Объект-пользователь, создающий комментарий
     * @return array ассоциативный массив 'id' => ID комментария
     */
    static public function createComment($number,$description,user $user) {
        $comment = new comment(new phoneNumber($number), $description, $user);
        commentsDataBaseRepository::saveComment($comment);
        return [$comment];
    }

    static public function getCommentsByNumber($number) {
        return commentsDataBaseRepository::getCommentsByNumber(new phoneNumber($number));
    }

    static public function getNumbersByPattern($pattern) {
        return numbersDateBaseRepository::getNumbersByPattern($pattern);
    }


    /** Повышение рейтинга комментария
     * @param integer $commentID ID комментария
     * @param user $user Объект-пользователь, повышающий рейтинг
     * @return array ассоциативный массив 'rating' => рейтинг комментария
     */
    static public function addRate($commentID, user $user) {
        $comment = commentsDataBaseRepository::getCommentByID($commentID);
        $comment->addRate($user);
        return ['rating' => $comment->getRate()];
    }

    /** Понижение рейтинга комментария
     * @param integer $commentID ID комментария
     * @param user $user Объект-пользователь, понижающий рейтинг
     * @return array ассоциативный массив 'rating' => рейтинг комментария
     */
    static public function downRate($commentID, user $user) {
        $comment = commentsDataBaseRepository::getCommentByID($commentID);
        $comment->downRate($user);
        return ['rating' => $comment->getRate()];
    }
}