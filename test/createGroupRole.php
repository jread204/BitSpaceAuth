<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-08-03
 * Time: 8:30 AM
 */
include 'header.php';
require_once 'Nav.php';
if (isset($_GET['id']))
{
    $_SESSION['CurrentGroup'] = $_GET['id'];
    print_r($_GET['id']);
}

if (isset($_POST)&&!empty($_POST))
{
    $roleId = $auth->CreateRole($_SESSION['CurrentGroup'], $_POST['roleName'], $_POST['description']);
    if (isset($roleId) && ! empty($roleId))
    {

        header("Location:http://localhost:31337/auth/test/index.php");
    }
}

?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" role="form">
	<legend>Create a Group Role</legend>

    <div class="form-group">
        <label for="role" class="col-sm-2 control-label">Role</label>
        <input type="text" class="form-control" name="roleName" id="role" placeholder="Role Name Goes Here...">
    </div>

    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Role's Description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="Role's Description Goes Here...">
    </div>


    <button type="submit" class="btn btn-primary">Submit</button>
</form>
