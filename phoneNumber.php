<?php

class phoneNumber {

    private $number;
    private $country_code;
    private $comments_count;

    public function __construct(string $number) {
        $this->number = $number;
        $this->country_code = numberIdentify::identifyCountry($this);
    }

    public function setCommentsCount($count){
        $this->comments_count = $count;
    }

    public function getCommentsCount(){
        return $this->comments_count;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getCountryCode() {
        return $this->country_code;
    }
}