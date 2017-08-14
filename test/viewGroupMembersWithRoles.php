<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-08-03
 * Time: 2:00 PM
 */
include 'header.php';
require_once 'Nav.php';
$members = $auth->getGroupMembersWithRole($_GET['id']);
print_r($members);
?>

<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Usernames</th>
        <th>Role</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($members as $m): ?>

        <tr>
            <td><?=$m['Username']?></td>
            <td><?=$m['Role']?></td>
            <td><a href="editUserRole.php?group=<?=$m['GroupId'] ?>&User=<?=$m['UserId'] ?>">Edit Role</a></td>

        </tr>

    <?php endforeach; ?>
    </tbody>
</table>
