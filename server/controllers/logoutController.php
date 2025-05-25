<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../classes/users.php';

class LogoutController
{
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            setcookie(session_name(), '', time() - 42000, '/');
        }

        // Instantiate user just to use showAlert
        $database = new Database();
        $db = $database->connect();
        $user = new User($db);

        $user->showAlert("Logout Successful", "You have been logged out.", "success", "../../frontend/pages/login.html");
    }
}
