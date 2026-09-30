<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/Photo.php';

class CommentController extends Controller
{
    private Comment $commentModel;
    private Photo $photoModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
        $this->photoModel = new Photo();
    }

    /**
     * Store a new comment for a photo.
     *
     * @param int $photoId
     * @return void
     */
    public function store($photoId)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/auth');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header(
                'Location: /alzikrayat/public/photos/' .
                (int) $photoId
            );
            exit;
        }

        $photoId = (int) $photoId;
        $userId = (int) $_SESSION['user_id'];

        $photo = $this->photoModel->getById($photoId);

        if (!$photo) {
            http_response_code(404);
            echo 'Photo not found.';
            return;
        }

        if ($this->commentModel->hasUserCommented(
            $photoId,
            $userId
        )) {
            die('You have already commented on this photo.');
        }

        $commentText = trim(
            $_POST['comment'] ?? ''
        );

        if ($commentText === '') {
            die('Comment cannot be empty.');
        }

        if (strlen($commentText) > 1000) {
            die('Comment cannot exceed 1000 characters.');
        }

        $dateTime = date('Y-m-d H:i:s');

        $created = $this->commentModel->create(
            $photoId,
            $userId,
            $commentText,
            $dateTime
        );

        if (!$created) {
            die('Failed to save comment.');
        }

        header(
            'Location: /alzikrayat/public/photos/' .
            $photoId
        );
        exit;
    }
}