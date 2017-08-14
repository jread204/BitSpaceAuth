<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-08-03
 * Time: 2:00 PM
 */
include 'header.php';
require_once 'Nav.php';
$members = $auth->getGroupMembers($_GET['id']);
?>

<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Usernames</th>\
		</tr>
	</thead>
	<tbody>
    <?php foreach($members as $m): ?>

        <tr>
            <td><?=$m['Username']?></td>
        </tr>

    <?php endforeach; ?>
	</tbody>
</table>
