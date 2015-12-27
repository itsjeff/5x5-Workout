<?php
namespace core\User;

class User 
{
	private $sessionId = 'userId';

	public $db;

	public $userId;

	public $userData;


	/**
	 * Construct
	 */
	public function __construct($db) 
	{
		$this->db = $db;

		if ($this->isSignedIn()) {
			$this->userId = (int)$_SESSION['userId'];

			$this->prepareUserData();
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
	 * Prepare user data
	 */
	public function prepareUserData()
	{
		$query = "SELECT email, selected_workout_id FROM users AS u 
			LEFT JOIN users_profile AS profile ON profile.user_id = u.id
			WHERE u.id = ?";

		$user_stmt = $this->db->prepare($query);

		$user_stmt->bind_param('i', $this->userId);
		$user_stmt->execute();
		$user_stmt->bind_result($email, $routine);
		$user_stmt->store_result();
		$user_stmt->fetch();

		$this->userData = [
			'email' => $email,
			'routine' => $routine
			];	
	}

	/**
	 * Get user data
	 * 
	 * @param  string $key Specific user data key ie. email
	 * @return mixed       Return user data
	 */
	public function data($key) {
		return $this->userData[$key];
	}
}
