<?php
namespace core;

Class User 
{
	private $sessionId = 'userId';


	/**
	 * Check if user is signed in
	 * 
	 * @return boolean return true if user is
	 */
	function isSignedIn() 
	{
		if (isset($_SESSION[$this->sessionId]) && $_SESSION[$this->sessionId] > 0) {
			return true;
		}
	}

	/**
	 * Sign user out and destory session
	 */
	function signOut() 
	{
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-300, '/');
		}

		session_destroy();
	}
}