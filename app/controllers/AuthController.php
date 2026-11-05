<?php
// CONTROLLER: handles the form, asks the Model, then shows a View.
class AuthController {
    private $user;

    // Receives the User model so the controller can access user-related database functions.
    public function __construct($user) {
        $this->user = $user;
    }

    public function home() {
        require __DIR__ . '/../views/home.php';
    }

    public function login() {
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['user'] ?? '');
            $password = $_POST['pass'] ?? '';
            $foundUser = $this->user->findByUsername($username);

            if ($foundUser && password_verify($password, $foundUser['passwordHash'])) {
                $_SESSION['user_id'] = $foundUser['userId'];
                $_SESSION['user'] = $foundUser['username'];
                redirect_to('index.php?page=home');
            }

            $message = 'Username/password combination incorrect.';
        } elseif (isset($_GET['logout'])) {
            $message = 'You are now logged out.';
        }

        require __DIR__ . '/../views/login.php';
    }

    public function register() {
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['user'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['pass'] ?? '';

            if ($username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
                $message = 'Please provide a username, valid email, and password.';
            } else {
                try {
                    $this->user->create($username, $email, $password);
                    redirect_to('index.php?page=login');
                } catch (PDOException $exception) {
                    $message = 'That username or email is already in use.';
                }
            }
        }

        require __DIR__ . '/../views/register.php';
    }

    public function logout() {
        // Four steps to closing a session
		// (i.e. logging out)

		// 1. Unset all the session variables
		$_SESSION = array();
		
		// 2. Destroy the session cookie
		if(isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		
		// 3. Destroy the session
		session_destroy();
		
		redirect_to("index.php?page=login&logout=1");
    }
}