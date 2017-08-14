<?php
include 'header.php';
require_once 'Nav.php';

?>

<div class="container">
	<div class="jumbotron">
		<div class="container">
			<h1>Auth test </h1>
			<p>index page</p>
            <h3>Session looks like :</h3>

            <p><?=print_r($_SESSION) ?></p>

            <h3>Auth Looks Like:</h3>
            <p><?=print_r($auth->users) ?></p>
		</div>
	</div>
</div>
