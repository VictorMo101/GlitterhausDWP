<?php
	session_start();
	
	function logged_in() {
		return isset($_SESSION['user_id']);
	}

	function is_admin() {
		return logged_in() && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}
?>