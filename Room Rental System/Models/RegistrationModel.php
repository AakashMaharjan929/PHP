<?php
class RegisterUser {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registerUser($name, $email, $phone, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $hashedPassword, $role);
        $stmt->execute();
        $stmt->close();
    }
}

class LoginUser{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function loginUser($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $user = $result->fetch_assoc();

        return $user;
    }
}
?>
