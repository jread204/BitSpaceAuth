

<div class="navbar">
    <a class="navbar-brand" href="index.php">Auth Test</a>
    <ul class="nav navbar-nav">

        <li class="active">
            <a href="registerTest.php">register</a>
        </li>

        <li>
            <a href="loginTest.php">login</a>
        </li>

        <?php if ($auth->checkIfLoggedIn($_SESSION['CurrentUser']) == true): ?>
            <li>
                <a href="dashTest.php?id=<?= $userId ?>">dashboard</a>
            </li>
            <li>
                <a href="createGroupTest.php?id=<?= $userId ?>"">Create Group</a>
            </li>
            <li>
                <a href="addMemberTest.php?id=<?= $userId ?>"">Add member</a>
            </li>
            <li>
                <a href="logoutTest.php">Log Out</a>
            </li>
        <?php endif; ?>
    </ul>
</div>