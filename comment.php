<?php

class comment {

    private $id = NULL; // id отзыва.
    private $phoneNumber; // Объект-Номер о котором написан отзыв.
    private $user; // Объект-пользователь оставивший отзыв.
    private $description; // Описание отзыва.
    private $rate; // Рейтинг отзыва.

    /**
     * @param phoneNumber $phoneNumber Номер телефона, к которому относится отзыв
     * @param string $description Описание комментария
     * @param user $user Объект-пользователь оставивший отзыв
     * @param integer $rate Изначальный рейтинг отзыва
     */
    public function __construct(phoneNumber $phoneNumber, string $description, user $user, $rate=0) {
        $this->phoneNumber = $phoneNumber;
        $this->description = $description;
        $this->user = $user;
        $this->rate = $rate;
    }

    public function getID() {
        return $this->id;
    }

    public function getUser() {
        return $this->user;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getRate() {
        return $this->rate;
    }

    public function setID($id) {
        $this->id = $id;
    }

    /**
     * Понижение рейтинга отзыва
     * @param user $user Объект-пользователя оставившего отзыв
     * @param integer $count количество, на которое надо понизить рейтинг отзыва
     */
    public function addRate(user $user,$count = 1) {
        if (!$user->isAnonym()) {
            if (!marksDataBaseRepository::isMarkComment($this,$user)) {
                $this->rate = $this->rate + $count;
                commentsDataBaseRepository::saveComment($this);
                marksDataBaseRepository::markCommentUser($this,$user);
            } else validation::setError(9);
        }
        else validation::setError(7);
    }

    /**
     * Понижение рейтинга отзыва
     * @param user $user Объект-пользователя оценившего отзыв
     * @param integer $count количество, на которое надо понизить рейтинг отзыва
     */
    public function downRate(user $user, $count = 1) {
        if (!$user->isAnonym()) {
            if (!marksDataBaseRepository::isMarkComment($this,$user)) {
                $this->rate = $this->rate - $count;
                commentsDataBaseRepository::saveComment($this);
                marksDataBaseRepository::markCommentUser($this,$user);
            } else validation::setError(9);
        }
        else validation::setError(7);
    }

}