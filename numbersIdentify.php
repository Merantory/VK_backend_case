<?php

class numberIdentify {

    /**
     * Проверка является ли номер российским
     * @param phoneNumber $phoneNumber Объект-номер, который проверяем
     * @return bool True-номер является российским, false-номер не является российским
     */
    static private function isRussianIdentify(phoneNumber $phoneNumber) {
        if (preg_match('/^[\d]/', $phoneNumber->getNumber())) return true;
        else return false; // Обработка false сделать.
    }

    /**
     * Определение кода страны, к которой принадлежит международный номер
     * @param phoneNumber $phoneNumber Объект-номер, который проверяем
     * @return string Код страны, к которой принадлежит номер
     */
    static private function internationalIdentify(phoneNumber $phoneNumber) {
        $code = false;
        // Сделать заполнение ас.массива через Config
        $codes = ['1905' => 'MX', '52' => 'MX', '86' => 'CH', '1' => 'US', '7' => 'RU'];
        krsort($codes); // Сортировка по ключу в порядке убывания.
        foreach ($codes as $key => $value) {
            if (preg_match('/^[+]('.$key.')/', $phoneNumber->getNumber())){
                $code = $value;
                break;
            }
        }
        if (empty($code)) validation::setError(8);
        return $code;
    }

    /**
     * Определение кода страны номера
     * @param phoneNumber $phoneNumber Объект-номер, который проверяем
     * @return string Код страны, к которой принадлежит номер
     */
    static public function identifyCountry(phoneNumber $phoneNumber):String {
        if (self::isRussianIdentify($phoneNumber)) {
            $country_code = 'RU';
        } else {
            $country_code = self::internationalIdentify($phoneNumber);
        }
        return $country_code;
    }
}