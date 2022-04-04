<?php

class auth
{
    /**
     * Проверка на существование пользователя с введенным токеном
     * @param string $token Токен пользователя
     * @return user Пользователь-объект, привязанный к токену, если пользователя не существует - возвращает пустого пользователя
     */
    static public function authentication($token)
    {
        $user = usersDataBaseRepository::getUserByToken($token);
        if ($user) {
            return $user;
        }
        else return new user(NULL, NULL);
    }
}