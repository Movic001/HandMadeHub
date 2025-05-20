<?php
class User
{
    private $db;

    public function __construct($dbConn)
    {
        $this->db = $dbConn;
    }

    public function register($data)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute([':email' => $data['email']]);
        if ($stmt->fetch()) {
            $this->showAlert("Email already exists", "Please use a different email.", "error", "../../frontend/pages/register.html");
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (fullName, userName, mobile, email, address, city, password, role, created_at) 
        VALUES (:fullName, :userName, :mobile, :email, :address, :city, :password, :role, NOW())";


        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            ':fullName' => filter_var($data['fullName'], FILTER_SANITIZE_STRING),
            ':userName' => filter_var($data['userName'], FILTER_SANITIZE_STRING),
            ':mobile'   => filter_var($data['mobile'], FILTER_SANITIZE_STRING),
            ':email'    => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            ':address'  => filter_var($data['address'], FILTER_SANITIZE_STRING),
            ':city'     => filter_var($data['city'], FILTER_SANITIZE_STRING),
            ':password' => $hashedPassword,
            ':role'     => filter_var($data['role'], FILTER_SANITIZE_STRING)
        ]);

        if (!$success) {
            throw new Exception("Registration failed");
        }

        return true;
    }


    public function authenticate($email, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => filter_var($email, FILTER_SANITIZE_EMAIL)]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }


    public function setUserSession($user)
    {
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_name']  = $user['userName'];
        $_SESSION['full_name']  = $user['fullName'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_mobile'] = $user['mobile'];
        $_SESSION['user_role']  = $user['role'];
        $_SESSION['logged_in']  = true;
    }

    public function getUserById($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => filter_var($userId, FILTER_SANITIZE_NUMBER_INT)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUserRole($userId, $newRole)
    {
        $allowedRoles = ['user', 'admin'];
        if (!in_array($newRole, $allowedRoles)) {
            $this->showAlert("Invalid role specified", "Please select a valid role.", "error", "../../frontend/pages/adminDashboard/pages/adminDashboard.php");
        }

        $stmt = $this->db->prepare("UPDATE users SET role = :role WHERE id = :id");
        return $stmt->execute([
            ':role' => $newRole,
            ':id' => filter_var($userId, FILTER_SANITIZE_NUMBER_INT)
        ]);
    }

    public function verifyUserRole($userId)
    {
        $stmt = $this->db->prepare("SELECT role FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => filter_var($userId, FILTER_SANITIZE_NUMBER_INT)]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['role'] : null;
    }

    public function validateSession()
    {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        $dbRole = $this->verifyUserRole($_SESSION['user_id']);
        if ($_SESSION['user_role'] !== $dbRole) {
            $_SESSION['user_role'] = $dbRole;
        }

        return true;
    }

    public function showAlert($title, $text, $icon, $redirectUrl)
    {
        $alertTitle = $title;
        $alertText = $text;
        $alertIcon = $icon;
        include(__DIR__ . "/../../frontend/pages/sweetAlert/alertTemplate.php");
        exit;
    }
}
