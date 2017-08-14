<?php
include 'header.php';
require_once 'Nav.php';
$groups = $auth->getUserGroups($_SESSION['CurrentUser']);

?>
<?php if (isset($groups)&&!empty($groups)): ?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
                <th>Group</th>
				<th>basic</th>
                <th>detail</th>
                <th>Role</th>
                <th>members</th>
                <th>enrollment</th>
			</tr>
		</thead>
		<tbody>
        <?php foreach ($groups as $key ): ?>
            <tr>
                <td><?= $key['Name']?></td>
                <td><a href="viewGroupMembers.php?id=<?=$key['Id'] ?>">View</a></td>

                <td><a href="viewGroupMembersWithRoles.php?id=<?=$key['Id'] ?>">View</a></td>

                <td><a href="createGroupRole.php?id=<?=$key['Id'] ?>">Add</a></td>

                <td><a href="addMemberTest.php?id=<?=$key['Id'] ?>">Add</a></td>

                <td><a href="SendEnrollmentTest.php?id=<?=$key['Id']?>"">Enroll</a></td>
            </tr>
        <?php endforeach; ?>

		</tbody>
	</table>
        <?php else:?>
        <li>
            <a href="createGroupTest.php?id=<?=$userId?>"">Create New Group</a>
        </li>
    <?php endif ?>
</div>




