<?php
include 'Methods/apiMethods.php';
include 'Repositories/commentsDataBaseRepository.php';
include 'Repositories/DataBaseRepository.php';
include 'Repositories/numbersDateBaseRepository.php';
include 'Repositories/usersDataBaseRepository.php';
include 'validation.php';
include 'apiDataPost.php';
include 'apiJSON.php';
include 'auth.php';
include 'comment.php';
include 'numbersIdentify.php';
include 'phoneNumber.php';
include 'user.php';


DataBaseRepository::setDataBase(new MysqlEngine(new mysqli('localhost','root','','VK')));
$data = apiDataPost::getData();
if (!validation::isValid($data)) {
    apiJSON::sendData(apiJSON::prepareData(validation::getError(),$data['method']));
    exit();
}

$user = auth::authentication($data['token']);
$result = apiMethods::callMethod($data['method'],$user,$data);
$result = apiJSON::prepareData(validation::getError(),$data['method'],$result);
apiJSON::sendData($result);
