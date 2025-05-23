<?php
session_start();
require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/../classes/users.php');

$database = new Database();
$db = $database->connect();

class RegisterController
{
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
            $formData = [
                'fullName' => trim($_POST['fullName']),
                'userName' => trim($_POST['userName']),
                'mobile'   => trim($_POST['mobile']),
                'email'    => trim($_POST['email']),
                'address'  => trim($_POST['address']),
                'city'     => trim($_POST['city']),
                'password' => $_POST['password'],
                'role'     => $_POST['role'] ?? 'user'
            ];

            // ✅ Validate mobile number BEFORE proceeding
            if (!preg_match('/^\+\d{1,4}\d{6,}$/', $formData['mobile'])) {
                $this->showAlert(
                    "Invalid Mobile Format",
                    "Please include your country code (e.g., +2349012345678).",
                    "error",
                    "../../frontend/pages/register.html"
                );
            }

            $user = new User($GLOBALS['db']);

            try {
                if ($user->register($formData)) {
                    $this->showAlert("Registration Successful", "You can now log in with your credentials.", "success", "../../frontend/pages/login.html");
                }
            } catch (Exception $e) {
                $this->showAlert("Error", "An error occurred during registration.", "error", "../../frontend/pages/register.html");
            }
        } else {
            $this->showAlert("Invalid request", "Please submit the form correctly.", "error", "../../frontend/pages/register.html");
        }
    }

    private function showAlert($title, $text, $icon, $redirectUrl)
    {
        $alertTitle = $title;
        $alertText = $text;
        $alertIcon = $icon;
        include(__DIR__ . "/../../frontend/pages/sweetAlert/alertTemplate.php");
        exit;
    }
}
