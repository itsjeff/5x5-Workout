<?php
namespace core;

class User 
{
	private $sessionId = 'userId';

	public $db;

	public $userId;


	/**
	 * Construct
	 */
	public function __construct($db) 
	{
		$this->db = $db;

		if ($this->isSignedIn()) {
			$this->userId = (int)$_SESSION['userId'];
		}
	}

	/**
	 * Check if user is signed in
	 * 
	 * @return boolean return true if user is
	 */
	public function isSignedIn() 
	{
		if (isset($_SESSION[$this->sessionId]) && $_SESSION[$this->sessionId] > 0) {
			return true;
		}
	}

	/**
	 * Sign user out and destory session
	 */
	public function signOut() 
	{
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-300, '/');
		}

		session_destroy();
	}

	/**
	 * 
	 */
	public function email() {
		$user_stmt = $this->db->prepare("SELECT email FROM users WHERE id = ?");

		$user_stmt->bind_param('i', $this->userId);
		$user_stmt->execute();
		$user_stmt->bind_result($myEmail);
		$user_stmt->store_result();
		$user_stmt->fetch();

		return $myEmail;
	}
}
