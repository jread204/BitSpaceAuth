<?php
include 'header.php';
require 'Nav.php';
echo $auth->name();
if (isset($_POST['username'])&& ! empty($_POST['username']) )
{

    $result  = $auth->login( $_POST['username'], $_POST['password'], false);

    if (isset($result))
    {
        $_SESSION['CurrentUser'] = $result;
        header("Location:http://localhost:31337/auth/test/index.php");
    }
}
?>

<?php if ($auth->checkIfLoggedIn($_SESSION['CurrentUser']) == false): ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" role="form">
        <legend>Form Title</legend>

        <div class="form-group">
            <label for="username">username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Input...">
        </div>
        <div class="form-group">
            <label for="password">password</label>
            <input type="text" class="form-control" name="password" id="password" placeholder="Input...">
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php else:?>

    <div class="alert alert-info text-center" role="alert">
        <strong>Dingus</strong> you are logged !! <br> <a href="logoutTest.php" class="alert-link">Log Out If You Really Wanna Log In</a>.
    </div>

<?php endif ?>
