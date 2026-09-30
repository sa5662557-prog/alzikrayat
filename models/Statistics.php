<?php

require_once __DIR__ . '/../config/database.php';

class Statistics
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Get the total number of registered users.
     *
     * @return int
     */
    public function getUsersCount(): int
    {
        $stmt = $this->db->query(
            "SELECT COUNT(*) FROM Users"
        );

        return (int) $stmt->fetchColumn();
    }

    /**
     * Get the total number of shared photos.
     *
     * @return int
     */
    public function getPhotosCount(): int
    {
        $stmt = $this->db->query(
            "SELECT COUNT(*) FROM Photos"
        );

        return (int) $stmt->fetchColumn();
    }

    /**
     * Get the total number of comments.
     *
     * @return int
     */
    public function getCommentsCount(): int
    {
        $stmt = $this->db->query(
            "SELECT COUNT(*) FROM Comments"
        );

        return (int) $stmt->fetchColumn();
    }
}