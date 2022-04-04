<?php

include 'Interfaces/IConvertData.php';

class apiJSON implements IConvertData {

    static private $json;

    /** Подготовка данных к выводу в JSON
     * @param integer $status Код выполнения
     * @param string $method Запрошенный пользователем метод
     * @param array $data Массив данных
     * @return string Данные в формате JSON
     */
    static public function prepareData(int $status,$method,array $data=[]) {
        if ($method == 'getCommentsByNumber') $data = self::convertCommentsArray($data);
        elseif ($method == 'getNumbersByPattern') $data = self::convertNumbersArray($data);
        $data['Code'] = $status;
        self::$json = json_encode($data,JSON_UNESCAPED_UNICODE);
        return self::$json;
    }

    static public function sendData($data) {
        echo $data;
    }

    /** Конвертация массива объектов-номеров в ассоциативный массив
     * @param array $array Массив объектов-номеров
     * @return array Преобразованный массив
     */
    static public function convertNumbersArray(array $array) {
        $final_array = [];
        foreach ($array as $value) {
            $final_array[] = ['number' => $value->getNumber(),
                'countryCode' => $value->getCountryCode(),
                'commentsCount' => $value->getCommentsCount()];
        }
        return $final_array;
    }

    /** Конвертация многомерного массива объектов-комментариев в ассоциативный массив
     * @param array $array Массив объектов-комментариев
     * @return array Преобразованный массив
     */
    static public function convertCommentsArray(array $array) {
        $final_array = [];
        foreach ($array as $value) {
            $final_array['response'] = ['id' => $value->getID(),
                'user' => $value->getUser()->getUsername(),
                'number' => $value->getPhoneNumber()->getNumber(),
                'description' => $value->getDescription(),
                'rating' => $value->getRate()];
        }
        return $final_array;
    }
}