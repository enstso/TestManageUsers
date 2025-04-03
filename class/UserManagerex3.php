<?php
namespace Vendor\UnitTesting;
use PDO;
use Exception;
use \InvalidArgumentException;
class UserManagerex3 {
    private PDO $db;

    public function __construct() {
        $dsn = "mysql:host=mariadb;dbname=user_management;charset=utf8";
        $username = "root"; // Modifier si besoin
        $password = "root"; // Modifier si besoin
        $this->db = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function addUser(string $name, string $email, $date): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide.");
        }

        $stmt = $this->db->prepare("INSERT INTO usersex3 (name, email, date) VALUES (:name, :email, :date)");
        $stmt->execute(['name' => $name, 'email' => $email, 'date'=>$date]);
    }

    public function removeUser(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM usersex3 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function getUsers(): array {
        $stmt = $this->db->query("SELECT * FROM usersex3");
        return $stmt->fetchAll();
    }

    public function getUser(int $id): array {
        $stmt = $this->db->prepare("SELECT * FROM usersex3 WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        if (!$user) throw new Exception("Utilisateur introuvable.");
        return $user;
    }

    public function updateUser(int $id, string $name, string $email, string $date ): void {
        $stmt = $this->db->prepare("UPDATE usersex3 SET name = :name, email = :email, date = :date WHERE id = :id");
        $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email, 'date' => $date]);
    }
}
?>
