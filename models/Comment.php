<?php

require_once __DIR__ . '/../config/database.php';

class Comment
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Get all comments for a specific photo.
     *
     * @param int $photoId
     * @return array
     */
    public function getByPhotoId(int $photoId): array
    {
        $sql = "
            SELECT
                Comments.id,
                Comments.photo_id,
                Comments.user_id,
                Comments.comment,
                Comments.date_time,
                Users.first_name,
                Users.last_name
            FROM Comments
            INNER JOIN Users
                ON Comments.user_id = Users.id
            WHERE Comments.photo_id = :photo_id
            ORDER BY Comments.date_time ASC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':photo_id' => $photoId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Check whether a user has already commented on a photo.
     *
     * @param int $photoId
     * @param int $userId
     * @return bool
     */
    public function hasUserCommented(
        int $photoId,
        int $userId
    ): bool {
        $sql = "
            SELECT id
            FROM Comments
            WHERE photo_id = :photo_id
            AND user_id = :user_id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':photo_id' => $photoId,
            ':user_id' => $userId
        ]);

        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new comment.
     *
     * @param int $photoId
     * @param int $userId
     * @param string $comment
     * @param string $dateTime
     * @return bool
     */
    public function create(
        int $photoId,
        int $userId,
        string $comment,
        string $dateTime
    ): bool {
        $sql = "
            INSERT INTO Comments
            (
                photo_id,
                user_id,
                comment,
                date_time
            )
            VALUES
            (
                :photo_id,
                :user_id,
                :comment,
                :date_time
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':photo_id' => $photoId,
            ':user_id' => $userId,
            ':comment' => $comment,
            ':date_time' => $dateTime
        ]);
    }
}