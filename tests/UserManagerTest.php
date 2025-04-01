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

    // This method sets up the necessary environment before each test is executed
    protected function setUp(): void
    {
        // Create a new instance of UserManager for each test
        $this->userManager = new UserManager();
    }

    // Test case for adding a new user
    public function testAddUser(): void
    {
        // Add a new user and verify it's successfully added to the database
        $this->userManager->addUser("John Doe", "john@example.com");
        $users = $this->userManager->getUsers(); // Fetch all users
        $position = count($users) - 1; // Get the position of the last added user
        $id = count($users); // ID of the last added user
        $this->assertCount(count($users), $users); // Assert that the number of users is correct
        $user = $this->userManager->getUser($id); // Fetch the added user by ID
        // Verify that the added user's name and email match the values
        $this->assertEquals($user['name'], $users[$position]['name']);
        $this->assertEquals($user['email'], $users[$position]['email']);
    }

    // Test case for adding a user with an invalid email
    public function testAddUserEmailException(): void
    {
        // Expect an exception when adding a user with an invalid email format
        $this->expectException(InvalidArgumentException::class);
        $this->userManager->addUser("Johnny", "invalid-email");
    }

    // Test case for updating a user's information
    public function testUpdateUser(): void
    {
        // Add a user, then update their details and verify the update
        $this->userManager->addUser("Jane Bech", "jane@example.com");
        $usersBeforeUpdate = $this->userManager->getUsers(); // Fetch users before update
        $position = count($usersBeforeUpdate) - 1; // Get the position of the user to update
        $id  = count($usersBeforeUpdate); // ID of the user to update
        $this->userManager->updateUser($id, "Janou Smith", "janou.smith@example.com"); // Update user info
        $usersAfterUpdate = $this->userManager->getUsers(); // Fetch all users after the update
        $userUpdated = $this->userManager->getUser($id); // Fetch updated user by ID
        // Verify that the updated user's name and email match the new values
        $this->assertEquals($userUpdated['name'], $usersAfterUpdate[$position]['name']);
        $this->assertEquals($userUpdated['email'], $usersAfterUpdate[$position]['email']);
    }

    // Test case for removing a user from the database
    public function testRemoveUser(): void
    {
        // Add a user, then remove them and verify that the user is deleted
        $this->userManager->addUser("Alice", "alice@example.com");
        $usersBeforeRemove = $this->userManager->getUsers(); // Fetch users before removal
        $countUsers = count($usersBeforeRemove); // Store the count of users before removal
        $this->assertCount($countUsers, $usersBeforeRemove); // Assert the number of users before removal
        $id  = count($usersBeforeRemove); // ID of the user to remove
        $this->userManager->removeUser($id); // Remove the user
        $usersAfterRemove = $this->userManager->getUsers(); // Fetch users after removal
        // Verify that the number of users decreased by 1 after removal
        $this->assertCount($countUsers - 1, $usersAfterRemove);
    }

    // Test case for fetching the list of users
    public function testGetUsers(): void
    {
        $usersBeforeAdd = $this->userManager->getUsers(); // Fetch users before adding new ones
        $countUsers = count($usersBeforeAdd); // Store the initial count of users
        $this->assertCount($countUsers, $usersBeforeAdd); // Assert the count of users before adding new ones
        // Add two new users and verify they are added to the list
        $this->userManager->addUser("User One", "user1@example.com");
        $this->userManager->addUser("User Two", "user2@example.com");
        $usersAfterAdd = $this->userManager->getUsers(); // Fetch users after adding new ones
        // Assert that the number of users is correctly updated
        $this->assertCount(count($usersBeforeAdd) + 2, $usersAfterAdd);
    }

    // Test case for updating a non-existent user (should throw an exception)
    public function testInvalidUpdateThrowsException(): void
    {
        // Attempt to update a user that doesn't exist (ID 99), should throw an exception
        $this->userManager->updateUser(99, "Ghost", "ghost@example.com");
    }

    // Test case for removing a non-existent user (should throw an exception)
    public function testInvalidDeleteThrowsException(): void
    {
        // Attempt to remove a user that doesn't exist (ID 99), should throw an exception
        $this->userManager->removeUser(99);
    }
}
