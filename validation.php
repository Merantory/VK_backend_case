<?php

// 0 = OK
// 1 = Некорректный токен // Токен должен быть 32-х значным
// 2 = Некорректный номер
// 3 = Пустой параметр или его отсутствие
// 4 = Не указан метод или указан неверно
// 5 = Отсутствие входных данных
// 6 = Некорректный размер номера
// 7 = Неудачная попытка изменения рейтинга отзыва анонимным пользователем
// 8 = Неверный код международного номера

class validation {

    static private $error = 0;

    static public function getError() {
        return self::$error;
    }

    static public function setError(int $error) {
        self::$error = $error;
    }

    /** Проверка валидности номера
     * @param string $number Номер телефона, проверяемый на валидность
     * @return bool True - Валидный False - Невалидный
     */
    static private function numberIsValid($number) {
        if (preg_match('/^[+][\d]+$/', $number) || ctype_digit($number)){
            if (strlen($number) >= 2 && strlen($number) < 15) return true;
            else {
                self::$error = '6';
                return false;
            }
        }
        else {
            self::$error = '2';
            return false;
        }
    }

    /** Проверка валидности описания
     * @param string $description Отзыв, проверяемый на валидность
     * @return bool True - Валидный False - Невалидный
     */
    static private function descriptionIsValid($description) {
        if(empty($description)) return false;
        else return true;
    }

    /** Проверка валидности токена
     * @param string $token Токен, проверяемый на валидность
     * @return bool True - Валидный False - Невалидный
     */
    static private function tokenIsValid($token) {
        if (strlen($token) == 32) return true;
        else return false;
    }

    /** Проверка валидности данных
     * @param array $data Проверяемые данные
     * @return bool True - Валидные False - Невалидные
     */
    static public function isValid($data) {
        $methods = ['getCountryCode' => ['number'], 'createComment' => ['number','description'],
            'getCommentsByNumber' => ['number'], 'getNumbersByPattern' => ['pattern'], 'addRate' => ['commentID'], 'downRate' => ['commentID']];
        if (isset($data)) {
            if (isset($data['method'])){
                $method = $data['method'];
                unset($data['method']);
                if (isset($data['token'])) {
                    if (!self::tokenIsValid($data['token'])) self::$error = 1;
                }
                foreach ($methods[$method] as $value) {
                    if (array_key_exists($value, $data)) {
                        if ($value == 'number') {
                            self::numberIsValid($data[$value]);
                        }
                        if ($value == 'description') {
                            if (!self::descriptionIsValid($data[$value])) self::$error = 3;
                        }
                        if (self::$error) return false;
                    }
                    else {
                        self::$error = 3;
                        return false;
                    }
                }
                return true;
            }
            else {
                self::$error = 4;
                return false;
            }
        }
        else {
            self::$error = 5;
            return false;
        }
    }
}