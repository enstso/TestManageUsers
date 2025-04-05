<?php
// Déclaration du namespace pour organiser les classes
namespace Vendor\UnitTesting;

// Importation des classes nécessaires
use PDO;
use Exception;
use \InvalidArgumentException;

// Déclaration de la classe UserManagerex3
class UserManagerex3 {
    // Déclaration d'une propriété privée pour la connexion à la base de données
    private PDO $db;

    // Constructeur : initialise la connexion PDO à la base de données
    public function __construct() {
        // Définition du DSN pour la connexion MySQL avec l'encodage UTF-8
        $dsn = "mysql:host=mariadb;dbname=user_management;charset=utf8";
        $username = "root"; // Identifiant de la base de données
        $password = "root"; // Mot de passe de la base de données

        // Création de l'objet PDO avec options :
        // - activation des exceptions en cas d'erreur
        // - définition du mode de récupération par défaut à FETCH_ASSOC
        $this->db = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    // Méthode pour ajouter un utilisateur ajout du champ date
    public function addUser(string $name, string $email, $date): void {
        // Vérification que l'email est valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide.");
        }

        // Préparation de la requête d'insertion SQL avec le champ date
        $stmt = $this->db->prepare("INSERT INTO usersex3 (name, email, date) VALUES (:name, :email, :date)");
        
        // Exécution de la requête avec les paramètres fournis 
        $stmt->execute(['name' => $name, 'email' => $email, 'date'=>$date]);
    }

    // Méthode pour supprimer un utilisateur via son identifiant
    public function removeUser(int $id): void {
        // Préparation de la requête de suppression
        $stmt = $this->db->prepare("DELETE FROM usersex3 WHERE id = :id");
        
        // Exécution de la requête avec l'ID fourni
        $stmt->execute(['id' => $id]);
    }

    // Méthode pour récupérer tous les utilisateurs
    public function getUsers(): array {
        // Exécution d'une requête simple de sélection
        $stmt = $this->db->query("SELECT * FROM usersex3");
        
        // Récupération de tous les résultats sous forme de tableau associatif
        return $stmt->fetchAll();
    }

    // Méthode pour récupérer un utilisateur spécifique par son ID
    public function getUser(int $id): array {
        // Préparation de la requête de sélection
        $stmt = $this->db->prepare("SELECT * FROM usersex3 WHERE id = :id");
        
        // Exécution de la requête
        $stmt->execute(['id' => $id]);
        
        // Récupération du résultat
        $user = $stmt->fetch();

        // Si aucun utilisateur n'est trouvé, lancer une exception
        if (!$user) throw new Exception("Utilisateur introuvable.");
        
        // Retourne les données de l'utilisateur
        return $user;
    }

    // Méthode pour mettre à jour les informations d'un utilisateur avec son ID
    public function updateUser(int $id, string $name, string $email, string $date ): void {
        
        // Préparation de la requête de mise à jour les champs name, email et date
        $stmt = $this->db->prepare("UPDATE usersex3 SET name = :name, email = :email, date = :date WHERE id = :id");

        // Exécution de la requête avec les nouvelles données
        $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email, 'date' => $date]);
    }
}
?>
