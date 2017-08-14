<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-08-01
 * Time: 1:15 PM
 */
include 'header.php';
require_once 'Nav.php';
$_SESSION['CurrentGroup'] = $_GET['id'];
$users = $auth->getAllUsers();
$roles = $auth->getGroupRoles($_SESSION['CurrentGroup']);


if (isset($_POST['UserId'])&&isset($_POST['RoleId'])){

    $auth->addMemberToGroup($_POST['UserId'], $_SESSION['CurrentGroup'], $_POST['RoleId']);
}
print_r($roles);
?>

<form action="" method="POST" role="form">
	<legend>Add New Member to <?=$auth->getGroupName($_SESSION['CurrentGroup']) ?></legend>

	<div class="form-group">
		<label for="UserId">Select User</label>
        <select name="UserId" id="UserId">
            <?php foreach ($users as $u):?>
            <option value="<?=$u['Id'] ?>"><?=$u['Username']?></option>
            <?php endforeach;?>
        </select>
        <label for="RoleId"> Add Role</label>
        <select name="RoleId" id="RoleId">
            <?php foreach ($roles as $r):?>
                <option value="<?=$r['Id'] ?>"><?=$r['Role']?></option>
            <?php endforeach;?>
        </select>
	</div>

	<button type="submit" class="btn btn-primary">Submit</button>
</form>
