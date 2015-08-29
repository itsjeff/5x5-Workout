<?php
namespace App;

class User
{
	protected $sessionId = 'userId';

	public function foo()
	{
		echo 'test';
	}
	
	/**
	 * Determine if user is logged in or not
	 * based off session
	 * 
	 * @return bool
	 */
	public function logged()
	{
		if (isset($_SESSION[$this->sessionId]) && $_SESSION[$this->sessionId] > 0) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Get user's email if user is logged in and 
	 * has an id from session
	 * 
	 * @return string
	 */
	public function getEmail()
	{
		if ($this->logged()) {
			$userId = (int)$_SESSION['userId'];

			$user_stmt = $db->prepare("SELECT email FROM users WHERE id = ?");
			$user_stmt->bind_param('i', $userId);
			$user_stmt->execute();
			$user_stmt->bind_result($myEmail);
			$user_stmt->store_result();
			$user_stmt->fetch();
		}

		return $myEmail;
	}
}
