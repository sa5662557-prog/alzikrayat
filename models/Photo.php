<?php

require_once __DIR__ . '/../config/database.php';

class Photo
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Get all photos with their owner information.
     *
     * @return array
     */
    public function getAll(): array
    {
        $sql = "
            SELECT
                Photos.id,
                Photos.user_id,
                Photos.file_name,
                Photos.title,
                Photos.description,
                Photos.date_time,
                Users.first_name,
                Users.last_name
            FROM Photos
            INNER JOIN Users
                ON Photos.user_id = Users.id
            ORDER BY Photos.date_time DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get one photo by its ID.
     *
     * @param int $id
     * @return array|false
     */
    public function getById(int $id)
    {
        $sql = "
            SELECT
                Photos.id,
                Photos.user_id,
                Photos.file_name,
                Photos.title,
                Photos.description,
                Photos.date_time,
                Users.first_name,
                Users.last_name
            FROM Photos
            INNER JOIN Users
                ON Photos.user_id = Users.id
            WHERE Photos.id = :id
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new photo record.
     *
     * @param int $userId
     * @param string $fileName
     * @param string $title
     * @param string $description
     * @param string $dateTime
     * @return bool
     */
    public function create(
        int $userId,
        string $fileName,
        string $title,
        string $description,
        string $dateTime
    ): bool {
        $sql = "
            INSERT INTO Photos
            (
                user_id,
                file_name,
                title,
                description,
                date_time
            )
            VALUES
            (
                :user_id,
                :file_name,
                :title,
                :description,
                :date_time
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':user_id' => $userId,
            ':file_name' => $fileName,
            ':title' => $title,
            ':description' => $description,
            ':date_time' => $dateTime
        ]);
    }
        /**
     * Delete a photo owned by a specific user.
     *
     * @param int $photoId
     * @param int $userId
     * @return array|false
     */
    public function delete(
        int $photoId,
        int $userId
    ) {
        $sql = "
            SELECT file_name
            FROM Photos
            WHERE id = :id
            AND user_id = :user_id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $photoId,
            ':user_id' => $userId
        ]);

        $photo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$photo) {
            return false;
        }

        $deleteSql = "
            DELETE FROM Photos
            WHERE id = :id
            AND user_id = :user_id
        ";

        $deleteStmt = $this->db->prepare($deleteSql);

        $deleted = $deleteStmt->execute([
            ':id' => $photoId,
            ':user_id' => $userId
        ]);

        if (!$deleted) {
            return false;
        }

        return $photo;
    }
        /**
     * Get a photo only if it belongs to the given user.
     *
     * @param int $photoId
     * @param int $userId
     * @return array|false
     */
    public function getByIdAndUser(
        int $photoId,
        int $userId
    ) {
        $sql = "
            SELECT *
            FROM Photos
            WHERE id = :id
            AND user_id = :user_id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $photoId,
            ':user_id' => $userId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Update photo title and description.
     *
     * @param int $photoId
     * @param int $userId
     * @param string $title
     * @param string $description
     * @return bool
     */
    public function update(
        int $photoId,
        int $userId,
        string $title,
        string $description
    ): bool {
        $sql = "
            UPDATE Photos
            SET title = :title,
                description = :description
            WHERE id = :id
            AND user_id = :user_id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':id' => $photoId,
            ':user_id' => $userId
        ]);
    }
}