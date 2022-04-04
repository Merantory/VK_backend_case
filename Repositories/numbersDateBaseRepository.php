<?php

class numbersDateBaseRepository {

    /**
     * Подсчет количества отзывов конкретного номера
     * @param phoneNumber $phoneNumber Объект-номер, отзывы которого мы считаем
     * @return integer Количество комментариев у номера
     */
    static public function countNumberComments(phoneNumber $phoneNumber) {
        $number = $phoneNumber->getNumber();
        return (DataBaseRepository::$database->injection("SELECT COUNT(description) FROM `comments` WHERE number=?", 's', $number)->fetch_assoc())['COUNT(description)'];
    }

    /**
     * Получение номеров по их началу
     * @param string $pattern Начало номера-шаблон
     * @return array Объекты-номера, которые соответствуют шаблону
     */
    static public function getNumbersByPattern($pattern) {
        $pattern = "{$pattern}%";
        $numbers_arr = DataBaseRepository::$database->injection("SELECT number, COUNT(*) AS commentsCount FROM `comments` WHERE number LIKE ? GROUP BY number", 's', $pattern)->fetch_all(MYSQLI_ASSOC);
        $numbers_objects = [];
        foreach ($numbers_arr as $value){
            $obj = new phoneNumber($value['number']);
            $obj->setCommentsCount($value['commentsCount']);
            $numbers_objects[] = $obj;
        }
        return $numbers_objects;
    }
}