<?php

class usersDataBaseRepository {


    /**
     * Получение пользователя по токену
     * @param string $token Токен пользователя
     * @return user При успешном выполнении возвращает объект-пользователя, иначе false
     */
    static public function getUserByToken($token) {
        $user = DataBaseRepository::$database->injection("SELECT * FROM `users` WHERE token=?",'s',$token)->fetch_assoc();
        if ($user !== NULL) {
            $user_obj = new user($user['token'], $user['name']);
            $user_obj->setID($user['id']);
            return $user_obj;
        }
        else return false;
    }
}