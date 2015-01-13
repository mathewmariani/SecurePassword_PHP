<?php

/**
 * Simple, unobtrusive, and secure login and registration PHP.
 *
 * Future Plans:
 * - More Comments
 * - Better Security
 * - Single email registration
 * - Sessions
 *
 * @author Mathew 'matty' Mariani
 */
class user {
	private $db_connection = null;
	private $messages = array();

	public function __construct() {
		// Check for errors
		if (empty($_POST['email'])) {
			$this->messages[] = "email field was empty.";
		}
		elseif (empty($_POST['password'])) {
			$this->messages[] = "password field was empty.";
		}
		elseif (isset($_POST['email']) && isset($_POST['password'])) {
			$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			$this->db_connection->set_charset("utf8");

			if (!$this->db_connection->connect_errno) {
				if (isset($_POST["validate"])) {
					$this->validateUser();
				}
				elseif (isset($_POST["register"])) {
					$this->registerUser();
				}
			}
			else {
				$this->messages[] = "database connection error.";
			}
		}
	}

	function __destruct() {
		if ($this->db_connection != null) {
			$this->db_connection->close();
		}
	}

	private function registerUser() {
		// Sanitize Data
		$email = $this->db_connection->real_escape_string($_POST['email']);
		$password = $this->db_connection->real_escape_string($_POST['password']);

		// Hash password
		$hash = password_hash($password, PASSWORD_DEFAULT);

		$sql = "INSERT INTO users (email, password)
				VALUES ('$email', '$hash')";

		// NOTE: Multiple emails are allowed. To be fixed at a later date

		if($results = $this->db_connection->query($sql)) {
			$this->messages[] = "Successfully registered user.";
		}
		else {
			$this->messages[] = "Failed registered user.";
		}

		echo json_encode($this->messages);
	}

	private function validateUser() {
		// Sanitize Data
		$email = $this->db_connection->real_escape_string($_POST['email']);
		$password = $this->db_connection->real_escape_string($_POST['password']);

		$sql = "SELECT *
				FROM users
				WHERE email='$email'";

		if($results = $this->db_connection->query($sql)) {
			if ($results->num_rows > 0) {
				$result_object = $results->fetch_object();

				// Check password hash
				if(password_verify($password, $result_object->password)) {
					$this->messages[] = "Successfully validated user.";	
				}
				else {
					$this->messages[] = "Failed to validated user.";
				}
			}
			else {
				$this->messages[] = "No such user exists.";
			}
		}

		echo json_encode($this->messages);
	}
}
?>