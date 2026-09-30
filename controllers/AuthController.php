<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

/**
 * Handles user registration, login, logout,
 * and session-based authentication.
 */
class AuthController extends Controller
{
    /**
     * Displays the login and registration page.
     *
     * @return void
     */
    public function showAuth()
    {
        $lastLogin = $_COOKIE['last_login'] ?? null;

        $this->view('auth/login', [
    'lastLogin' => $lastLogin
       ]);
    }
/**
 * Displays the registration page.
 *
 * @return void
 */
public function showRegister()
{
    $this->view('auth/register');
}
    /**
     * Registers a new user account.
     *
     * @return void
     */
    public function register()
    {
        try {
            $userData = [
                'first_name' => trim($_POST['first_name'] ?? ''),
                'last_name' => trim($_POST['last_name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'location' => trim($_POST['location'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'occupation' => trim($_POST['occupation'] ?? '')
            ];

            $userModel = new User();

            if ($userModel->findByEmail($userData['email'])) {
                throw new InvalidArgumentException(
                    'This email address is already registered.'
                );
            }

            $userId = $userModel->create($userData);

            header('Location: /alzikrayat/public/?registered=1');
            exit;

        } catch (InvalidArgumentException $exception) {

            http_response_code(400);

            echo htmlspecialchars(
                $exception->getMessage(),
                ENT_QUOTES,
                'UTF-8'
            );
        }
    }

    /**
     * Authenticates a registered user and creates a session.
     *
     * @return void
     */
    public function login()
    {
        try {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException(
                    'Please enter a valid email address.'
                );
            }

            if ($password === '') {
                throw new InvalidArgumentException(
                    'Password is required.'
                );
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if (!$user || !password_verify($password, $user['password'])) {
                throw new InvalidArgumentException(
                    'Invalid email or password.'
                );
            }

            session_start();

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];

            $lastLoginTimestamp = date(
                'Y-m-d H:i:s'
            );

            setcookie(
                'last_login',
                $lastLoginTimestamp,
                time() + (7 * 24 * 60 * 60),
                '/'
            );

            header('Location: /alzikrayat/public/');
            exit;

        } catch (InvalidArgumentException $exception) {

            http_response_code(400);

            echo htmlspecialchars(
                $exception->getMessage(),
                ENT_QUOTES,
                'UTF-8'
            );
        }
    }

    /**
     * Logs out the current user and destroys the session.
     *
     * @return void
     */
    public function logout()
    {
        session_start();

        $_SESSION = [];

        session_destroy();

        header('Location: /alzikrayat/public/');
        exit;
    }
}