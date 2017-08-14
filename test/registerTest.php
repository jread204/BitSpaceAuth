<?php
include 'header.php';
require_once 'Nav.php';


if (isset($_POST)&& !empty($_POST))
{
    $auth->registar($_POST['username'], $_POST['password'], $_POST['email']);
}
echo $auth->name();
?>

<form method="post" action="./registerTest.php">

    <form action="<?= $_SERVER['PHP_SELF']?>" method="POST" role="form">
    	<legend>Form Title</legend>
    
    	<div class="form-group">
    		<label for="username">User Name</label>
    		<input type="text" class="form-control" name="username" id="username">
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <input type="text" class="form-control" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <input type="text" class="form-control" name="email" id="email">

        </div>

    
    	
    
    	<button type="submit" class="btn btn-primary">Submit</button>
    </form>
</form>
