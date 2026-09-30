<?php

require_once __DIR__ . '/../core/Model.php';

/**
 * User Model responsible for user data operations and validation.
 */
class User extends Model
{
    /**
     * Finds a user by their email address.
     *
     * @param string $email User email address.
     * @return array|false User record or false if no user is found.
     * @throws PDOException If the database query fails.
     */
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':email' => $email
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Finds a user by their numeric ID.
     *
     * @param int $userId User ID.
     * @return array|false User record or false if no user is found.
     * @throws PDOException If the database query fails.
     */
    public function findById($userId)
    {
        $sql = "SELECT * FROM users WHERE id = :userId LIMIT 1";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':userId' => $userId
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Creates a new user account with a securely hashed password.
     *
     * @param array $userData User registration data.
     * @return int The ID of the newly created user.
     * @throws InvalidArgumentException If required data is invalid.
     * @throws PDOException If the database query fails.
     */
    public function create($userData)
    {
        $this->validate($userData);

        $hashedPassword = password_hash(
            $userData['password'],
            PASSWORD_DEFAULT
        );

        $sql = "INSERT INTO users
                (first_name, last_name, email, password, location, description, occupation)
                VALUES
                (:firstName, :lastName, :email, :password, :location, :description, :occupation)";

        $statement = $this->db->prepare($sql);

        $statement->execute([
            ':firstName' => $userData['first_name'],
            ':lastName' => $userData['last_name'],
            ':email' => $userData['email'],
            ':password' => $hashedPassword,
            ':location' => $userData['location'] ?? null,
            ':description' => $userData['description'] ?? null,
            ':occupation' => $userData['occupation'] ?? null
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Validates registration data before saving it to the database.
     *
     * @param array $userData User registration data.
     * @return void
     * @throws InvalidArgumentException If validation fails.
     */
    public function validate($userData)
    {
        $firstName = trim($userData['first_name'] ?? '');
        $lastName = trim($userData['last_name'] ?? '');
        $email = trim($userData['email'] ?? '');
        $password = $userData['password'] ?? '';

        if ($firstName === '' || !preg_match('/^[a-zA-Z]+$/', $firstName)) {
            throw new InvalidArgumentException(
                'First name must contain letters only.'
            );
        }

        if ($lastName === '' || !preg_match('/^[a-zA-Z]+$/', $lastName)) {
            throw new InvalidArgumentException(
                'Last name must contain letters only.'
            );
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                'Please enter a valid email address.'
            );
        }

        if (strlen($password) < 8) {
            throw new InvalidArgumentException(
                'Password must be at least 8 characters long.'
            );
        }
    }
}