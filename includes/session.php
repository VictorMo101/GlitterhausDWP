<?php
	session_start();
	
	function logged_in() {
		return isset($_SESSION['user_id']);
	}

	function is_admin() {
		return logged_in() && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
	}

	function csrf_token() {
		if (!isset($_SESSION['csrf_token'])) {
			$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
		}
		return $_SESSION['csrf_token'];
	}

	function csrf_validate($token) {
		return isset($_SESSION['csrf_token'])
			&& is_string($token)
			&& hash_equals($_SESSION['csrf_token'], $token);
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}
?>