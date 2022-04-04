<?php

interface IConvertData {
    static public function prepareData(int $status,$method,array $data=[]);
    static public function sendData($data);
    static public function convertCommentsArray(array $array);
}