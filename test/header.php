<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-08-01
 * Time: 12:19 PM
 */


require_once('../AuthManager.php');

require_once ('../MySessionDelegate.php');

$session = new \aceAuth\MySessionDelegate();

$auth = new \aceAuth\AuthManager('auth', $session);

$_SERVER['Auth'] = $auth;
if (isset($_SESSION['CurrentUser'])&&!empty($_SESSION['CurrentUser']))
{
    $userId = $_SESSION['CurrentUser'];
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>header</title>
</head>
<body>

