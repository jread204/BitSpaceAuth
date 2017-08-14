<?php
/**
 * TODO Auto-generated comment.
 */
namespace aceAuth;
class MySessionDelegate implements SessionDelegate {

    function __construct()
    {
        session_start();
    }


	/**
	 * TODO Auto-generated comment.
	 */
	public function ReadAuthData($instanceName) {
        return (isset($_SESSION['Ace_Auth'][$instanceName])) ?
            $_SESSION['Ace_Auth'][$instanceName] :
            false;

	}

	/**
	 * TODO Auto-generated comment.
	 */
	public function WriteAuthData($instanceName,$data) {
        $_SESSION['Ace_Auth'][$instanceName] = $data;
        return true;
	}

	/**
	 * TODO Auto-generated comment.
	 */
	public function destroySession($instanceName) {
        unset($_SESSION['Ace_Auth'][$instanceName]);
	}
}
