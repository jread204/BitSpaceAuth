<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-08-08
 * Time: 9:25 AM
 */
include 'header.php';
require_once 'Nav.php';
if (isset($_GET['group']) && isset($_GET['User'])) {
    $_SESSION['group'] = $_GET['group'];
    $_SESSION['User'] = $_GET['User'];
}

$roles = $auth->getGroupRoles($_SESSION['group']);

if (isset($_POST['RoleId']) && !empty($_POST['RoleId']))
{
    $auth->editMemberRole($_SESSION['group'], $_SESSION['User'],$_POST['RoleId']);
}

?>

<form action="" method="POST" role="form">
	<legend>Form Title</legend>

    <label for="RoleId"> Add Role</label>
    <select name="RoleId" id="RoleId">
        <?php foreach ($roles as $r):?>
            <option value="<?=$r['Id'] ?>"><?=$r['Role']?></option>
        <?php endforeach;?>
    </select>


	<button type="submit" class="btn btn-primary">Submit</button>
</form>