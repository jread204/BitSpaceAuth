<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-08-02
 * Time: 10:23 AM
 */


?>


<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" role="form">
	<legend>Form Title</legend>

	<div class="form-group">
		<label for="groupName"></label>
		<input type="text" class="form-control" name="groupName" id="groupName" placeholder="Group Name...">
	</div>

    <div class="form-group">
        <label for="roleName"></label>
        <input type="text" class="form-control" name="roleName" id="roleName" placeholder="Role Name...">
    </div>

    <div class="form-group">
        <label for="roleDescription"></label>
        <input type="text" class="form-control" name="roleDescription" id="roleDescription" placeholder="Role Description...">
    </div>

   	<button type="submit" class="btn btn-primary">Submit</button>
</form>