<?php
require_once __DIR__ . '/../classes/users.php';

class LoginController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function login($email, $password)
    {
        $user = $this->userModel->authenticate($email, $password);

        if ($user) {
            $this->userModel->setUserSession($user);

            // Redirect based on role
            switch ($user['role']) {
                case 'seller':
                    $this->userModel->showAlert("login succesfully", "redirecting to the seller dashboard", "success", "../../frontend/pages/seller/pages/sellerDashboard.php");
                    // header("Location: ../../frontend/pages/seller/sellerDashboard.php");
                    break;
                case 'buyer':
                    $this->userModel->showAlert("login succesfully", "redirecting to the buyer dashboard", "success", "../../frontend/pages/buyer/pages/buyerDashboard.php");
                    // header("Location: ../../frontend/pages/buyer/buyerDashboard.php");
                    break;
                default:
                    $this->userModel->showAlert("Login Failed", "Unknown user role.", "error", "../../frontend/pages/login.html");
                    break;
            }
            exit;
        } else {
            $this->userModel->showAlert("Login Failed", "Invalid email or password.", "error", "../../frontend/pages/login.html");
        }
    }
}
