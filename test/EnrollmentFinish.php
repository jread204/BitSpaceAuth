<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-08-11
 * Time: 9:04 AM
 */
include 'header.php';
require_once 'Nav.php';
if (isset($_POST['username'])&&isset($_POST['password'])) {
    $params = [
        'id'       => filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'username' => filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    ];
    $auth->SetUpEnrolledAccount($params);

    header("Location:http://localhost:31337/auth/test/index.php");
    exit();
}