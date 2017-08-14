<?php
require_once('../AuthManager.php');
require_once ('../MySessionDelegate.php');
include 'header.php';
require_once 'Nav.php';




$auth->logout($_SESSION['CurrentUser']);
header("Location:http://localhost:31337/auth/test/index.php");
