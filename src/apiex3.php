<?php
// Importation de la classe UserManagerex3 depuis le namespace Vendor\UnitTesting
use Vendor\UnitTesting\UserManagerex3;

// Inclusion du fichier contenant la définition de la classe UserManagerex3
require_once '../class/UserManagerex3.php';

// Définition de l'en-tête pour indiquer que la réponse sera en JSON
header("Content-Type: application/json");

// Récupération de la méthode HTTP utilisée (GET, POST, PUT, DELETE, etc.)
$method = $_SERVER['REQUEST_METHOD'];

// Instanciation de l'objet UserManagerex3 pour gérer les opérations sur les utilisateurs
$userManager = new UserManagerex3();

try {
    // Si la méthode est POST et que les champs name et email sont présents dans $_POST
    if ($method === 'POST' && isset($_POST['name'], $_POST['email'])) {
        // Ajoute un utilisateur avec les données fournies + le champ date
        $userManager->addUser($_POST['name'], $_POST['email'], $_POST['date']);
        // Répond avec un message JSON de confirmation
        echo json_encode(["message" => "Utilisateur ajouté avec succès"]);

    // Si la méthode est GET, on retourne tous les utilisateurs
    } elseif ($method === 'GET') {
        echo json_encode($userManager->getUsers());

    // Si la méthode est DELETE et que l'identifiant est fourni via $_GET
    } elseif ($method === 'DELETE' && isset($_GET['id'])) {
        // Supprime l'utilisateur correspondant à l'ID
        $userManager->removeUser($_GET['id']);
        // Répond avec un message de confirmation
        echo json_encode(["message" => "Utilisateur supprimé"]);

    // Si la méthode est PUT (mise à jour d'un utilisateur)
    } elseif ($method === 'PUT') {
        // Récupère le contenu brut du corps de la requête et le parse en tableau $_PUT
        parse_str(file_get_contents("php://input"), $_PUT);

        // Vérifie que les champs nécessaires sont présents
        if (isset($_PUT['id'], $_PUT['name'], $_PUT['email'])) {
            // Met à jour les données de l'utilisateur avec les champs fournis + le champ date
            $userManager->updateUser($_PUT['id'], $_PUT['name'], $_PUT['email'], $_PUT['date']);
            // Répond avec un message de succès
            echo json_encode(["message" => "Utilisateur mis à jour"]);
        }

    // Si aucune condition n'est remplie, on considère la requête comme invalide
    } else {
        throw new Exception("Requête invalide.");
    }

// Gestion des erreurs via un bloc try/catch
} catch (Exception $e) {
    // Envoie un code HTTP 400 pour indiquer une erreur côté client
    http_response_code(400);
    // Répond avec le message d'erreur en JSON
    echo json_encode(["error" => $e->getMessage()]);
}
?>
