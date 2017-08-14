<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-08-01
 * Time: 1:15 PM
 */
include 'header.php';
require_once 'Nav.php';
if (isset($_POST)&&!empty($_POST))
{

    $worked = $auth->addMemberToGroup($_SESSION['CurrentUser'], $auth->createGroup($_POST['GroupName'], $_POST['Description']));
    if (isset($worked) && ! empty($worked))
    {

            header("Location:http://localhost:31337/auth/test/index.php");
    }
}

?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" role="form">
    <legend>Form Title</legend>

    <div class="form-group">
        <label for="GroupName">Group Name</label>
        <input type="text" class="form-control" name="GroupName" id="GroupName" placeholder="Group Name goes here ...">
    </div>

    <div class="form-group">
        <label for="Description">Description</label>
        <input type="text" class="form-control" name="Description" id="Description" placeholder="Description of your Group...">
    </div>


    <button type="submit" class="btn btn-primary">Submit</button>
</form>
