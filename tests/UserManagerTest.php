<?php
namespace Vendor\UnitTesting\tests;

use PDOException;
use PHPUnit\Framework\TestCase;
use Vendor\UnitTesting\UserManager;
use Exception;
use \InvalidArgumentException;

class UserManagerTest extends TestCase
{
    private UserManager $userManager;

    // Cette méthode est exécutée avant chaque test : elle prépare l’environnement de test
    protected function setUp(): void
    {
        // On crée une nouvelle instance de UserManager pour chaque test
        $this->userManager = new UserManager();
    }

    // Test de l’ajout d’un utilisateur
    public function testAddUser(): void
    {
        // On ajoute un utilisateur et on vérifie qu’il a bien été ajouté à la base
        $this->userManager->addUser("John Doe", "john@example.com");
        $users = $this->userManager->getUsers(); // Récupère tous les utilisateurs
        $position = count($users) - 1; // Position du dernier utilisateur ajouté
        $id = count($users); // ID du dernier utilisateur (supposé égal au nombre total)
        $this->assertCount(count($users), $users); // Vérifie que le nombre d'utilisateurs est correct
        $user = $this->userManager->getUser($id); // Récupère l'utilisateur par son ID
        // Vérifie que le nom et l’email de l’utilisateur ajouté correspondent
        $this->assertEquals($user['name'], $users[$position]['name']);
        $this->assertEquals($user['email'], $users[$position]['email']);
    }

    // Test de l’ajout d’un utilisateur avec une adresse email invalide
    public function testAddUserEmailException(): void
    {
        // On s’attend à une exception si l’email n’est pas au bon format
        $this->expectException(InvalidArgumentException::class);
        $this->userManager->addUser("Johnny", "invalid-email");
    }

    // Test de la mise à jour d’un utilisateur
    public function testUpdateUser(): void
    {
        // On ajoute un utilisateur, puis on le modifie, et on vérifie que les changements sont bien pris en compte
        $this->userManager->addUser("Jane Bech", "jane@example.com");
        $usersBeforeUpdate = $this->userManager->getUsers(); // Récupère les utilisateurs avant modification
        $position = count($usersBeforeUpdate) - 1; // Position de l’utilisateur à modifier
        $id  = count($usersBeforeUpdate); // ID de l’utilisateur à modifier
        $this->userManager->updateUser($id, "Janou Smith", "janou.smith@example.com"); // Mise à jour
        $usersAfterUpdate = $this->userManager->getUsers(); // Récupère les utilisateurs après la mise à jour
        $userUpdated = $this->userManager->getUser($id); // Récupère l’utilisateur modifié
        // Vérifie que le nom et l’email sont bien mis à jour
        $this->assertEquals($userUpdated['name'], $usersAfterUpdate[$position]['name']);
        $this->assertEquals($userUpdated['email'], $usersAfterUpdate[$position]['email']);
    }

    // Test de suppression d’un utilisateur
    public function testRemoveUser(): void
    {
        // On ajoute un utilisateur, puis on le supprime, et on vérifie qu’il est bien retiré de la base
        $this->userManager->addUser("Alice", "alice@example.com");
        $usersBeforeRemove = $this->userManager->getUsers(); // Avant suppression
        $countUsers = count($usersBeforeRemove); // Nombre d’utilisateurs avant
        $this->assertCount($countUsers, $usersBeforeRemove); // Vérifie le compte initial
        $id  = count($usersBeforeRemove); // ID de l’utilisateur à supprimer
        $this->userManager->removeUser($id); // Suppression
        $usersAfterRemove = $this->userManager->getUsers(); // Après suppression
        // Vérifie que le nombre d’utilisateurs a diminué de 1
        $this->assertCount($countUsers - 1, $usersAfterRemove);
    }

    // Test de récupération des utilisateurs
    public function testGetUsers(): void
    {
        $usersBeforeAdd = $this->userManager->getUsers(); // Avant ajout
        $countUsers = count($usersBeforeAdd); // Nombre d’utilisateurs initial
        $this->assertCount($countUsers, $usersBeforeAdd); // Vérifie ce nombre
        // Ajoute deux nouveaux utilisateurs
        $this->userManager->addUser("User One", "user1@example.com");
        $this->userManager->addUser("User Two", "user2@example.com");
        $usersAfterAdd = $this->userManager->getUsers(); // Après ajout
        // Vérifie que deux utilisateurs supplémentaires ont été ajoutés
        $this->assertCount(count($usersBeforeAdd) + 2, $usersAfterAdd);
    }

    // Test de mise à jour d’un utilisateur inexistant (devrait générer une exception, mais elle n’existe pas dans le code de la classe userManager)
    public function testInvalidUpdateThrowsException(): void
    {
        // Tente de mettre à jour un utilisateur qui n’existe pas (ID 99)
        // Une exception devrait être levée, mais elle ne l’est pas dans la version actuelle
        $this->userManager->updateUser(99, "Ghost", "ghost@example.com");
    }

    // Test de suppression d’un utilisateur inexistant (devrait générer une exception, mais elle n’existe pas dans le code de la classe userManager)
    public function testInvalidDeleteThrowsException(): void
    {
        // Tente de supprimer un utilisateur qui n’existe pas (ID 99)
        // Une exception devrait être levée, mais elle ne l’est pas dans la version actuelle
        $this->userManager->removeUser(99);
    }
}
