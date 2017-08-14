<?php
/**
 * SessionDelegate
 */
namespace aceAuth;
interface SessionDelegate {

	public function ReadAuthData($instanceName);

	public function WriteAuthData($instanceName,$data);

	public function destroySession($instanceName);
}
