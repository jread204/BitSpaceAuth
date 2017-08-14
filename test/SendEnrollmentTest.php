<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-08-09
 * Time: 1:25 PM
 */
include 'header.php';
require_once 'Nav.php';

if (isset($_GET['id'])) {
    $_SESSION['CurrentGroup'] = $_GET['id'];
}

if (isset($_POST['email'])){

    $r = $auth->sendEnrollEmail($_SESSION['CurrentGroup'],$_POST['email'],'http://localhost:31337/auth/test/enrollmentTest.php');
    print_r($r);
}

?>

<form class="form-inline" action="<?=$_SERVER['PHP_SELF']?>" method="POST" role="form">
    <legend>Add New Member to <?=$auth->getGroupName($_SESSION['CurrentGroup']) ?></legend>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" class="">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>