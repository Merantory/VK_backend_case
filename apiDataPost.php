<?php
include 'Interfaces/IAPIData.php';

class apiDataPost implements IAPIData {
    static public function getData() {
        return $_POST;
    }
}