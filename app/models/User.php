<?php
// This model contains database code for users.
class User {
    private $connection;

    // Store the database connection.
    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function create($username, $email, $password) {
        $query = "INSERT INTO users (username, email, passwordHash)
                  VALUES (:username, :email, :passwordHash)";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':username' => $username,
            ':email' => $email,
            ':passwordHash' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public function findByUsername($username) {
        $query = "SELECT userId, username, passwordHash
                  FROM users WHERE username = :username LIMIT 1";
        $statement = $this->connection->prepare($query);
        $statement->execute([':username' => $username]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
