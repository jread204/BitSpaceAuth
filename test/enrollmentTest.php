<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-08-09
 * Time: 1:25 PM
 */
include 'header.php';
require_once 'Nav.php';

$token = $_GET['token'];

$user=$auth->RetrieveEnrolledAccount($token);

?>
<form action="EnrollmentFinish.php" method="POST" role="form">
	<legend>Finish Enrollment</legend>

	<div class="form-group">
        <label for="username">New Username</label>
        <input type="text" class="form-control" name="username" id="username" value="<?=$user['Username']?>">
    </div>

    <div class="form-group">
        <label for="password">New Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Enter New Password Here">
    </div>

    <input title="hidden" type="hidden" name="id" value="<?=$user['Id'] ?>">
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
