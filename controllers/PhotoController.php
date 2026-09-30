<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Photo.php';
require_once __DIR__ . '/../models/Comment.php';

/**
 * Handles photo gallery, upload, and photo details.
 */
class PhotoController extends Controller
{
    private Photo $photoModel;
    private Comment $commentModel;

    /**
     * Creates the Photo model used by this controller.
     *
     * @return void
     */
    public function __construct()
    {
        $this->photoModel = new Photo();
        $this->commentModel = new Comment();
    }

    /**
     * Displays all photos in the gallery.
     *
     * @return void
     */
    public function index()
    {
        $photos = $this->photoModel->getAll();

        $this->view('photos/index', [
            'photos' => $photos
        ]);
    }

    /**
     * Displays the photo upload form for authenticated users.
     *
     * @return void
     */
    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/auth');
            exit;
        }

        $this->view('photos/create');
    }

    /**
     * Stores an uploaded photo after validating the file and form data.
     *
     * @return void
     */
    public function store()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/auth');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /alzikrayat/public/photos/create');
            exit;
        }

        if (
            !isset($_FILES['photo']) ||
            $_FILES['photo']['error'] !== UPLOAD_ERR_OK
        ) {
            die('Please select a valid photo.');
        }

        $file = $_FILES['photo'];

        $maxFileSize = 5 * 1024 * 1024;

        if ($file['size'] > $maxFileSize) {
            die('Photo size must not exceed 5 MB.');
        }

        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif'
        ];

        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file(
            $fileInfo,
            $file['tmp_name']
        );
        finfo_close($fileInfo);

        if (!in_array($mimeType, $allowedMimeTypes, true)) {
            die('Only JPG, PNG, and GIF images are allowed.');
        }

        $extensionMap = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif'
        ];

        $extension = $extensionMap[$mimeType];

        $newFileName = uniqid(
            'photo_',
            true
        ) . '.' . $extension;

        $uploadDirectory = __DIR__ .
            '/../public/images/uploads/';

        if (!is_dir($uploadDirectory)) {
            mkdir(
                $uploadDirectory,
                0755,
                true
            );
        }

        $destination = $uploadDirectory .
            $newFileName;

        if (!move_uploaded_file(
            $file['tmp_name'],
            $destination
        )) {
            die('Failed to upload the photo.');
        }

        $title = trim(
            $_POST['title'] ?? ''
        );

        $description = trim(
            $_POST['description'] ?? ''
        );

        if ($title === '') {
            if (file_exists($destination)) {
                unlink($destination);
            }

            die('Photo title is required.');
        }

        $dateTime = date(
            'Y-m-d H:i:s'
        );

        $created = $this->photoModel->create(
            (int) $_SESSION['user_id'],
            $newFileName,
            $title,
            $description,
            $dateTime
        );

        if (!$created) {
            if (file_exists($destination)) {
                unlink($destination);
            }

            die('Failed to save photo information.');
        }

        header(
            'Location: /alzikrayat/public/photos'
        );
        exit;
    }
        /**
     * Deletes a photo owned by the currently authenticated user.
     *
     * @param int $id Photo identifier.
     * @return void
     */
    public function delete($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/auth');
            exit;
        }

        $photoId = (int) $id;
        $userId = (int) $_SESSION['user_id'];

        $photo = $this->photoModel->delete(
            $photoId,
            $userId
        );

        if (!$photo) {
            http_response_code(403);
            echo 'You are not allowed to delete this photo.';
            return;
        }

        $filePath = __DIR__ .
            '/../public/images/uploads/' .
            $photo['file_name'];

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        header('Location: /alzikrayat/public/photos');
        exit;
    }

    /**
     * Displays the details of one photo.
     *
     * @param int $id Photo identifier.
     * @return void
     */
    public function show($id)
{
    $photo = $this->photoModel->getById((int) $id);

    if (!$photo) {
        http_response_code(404);
        echo 'Photo not found.';
        return;
    }

    $comments = $this->commentModel->getByPhotoId(
        (int) $id
    );

    $canComment = false;

    if (isset($_SESSION['user_id'])) {
        $canComment = !$this->commentModel->hasUserCommented(
            (int) $id,
            (int) $_SESSION['user_id']
        );
    }

    $this->view('photos/show', [
        'photo' => $photo,
        'comments' => $comments,
        'canComment' => $canComment
    ]);
}
    /**
     * Display the edit form for a photo owned by the current user.
     *
     * @param int $id Photo identifier.
     * @return void
     */
    public function edit($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/auth');
            exit;
        }

        $photoId = (int) $id;
        $userId = (int) $_SESSION['user_id'];

        $photo = $this->photoModel->getByIdAndUser(
            $photoId,
            $userId
        );

        if (!$photo) {
            http_response_code(403);
            echo 'You are not allowed to edit this photo.';
            return;
        }

        $this->view('photos/edit', [
            'photo' => $photo
        ]);
    }
        /**
     * Update the title and description of an owned photo.
     *
     * @param int $id Photo identifier.
     * @return void
     */
    public function update($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/auth');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header(
                'Location: /alzikrayat/public/photos/' .
                (int) $id
            );
            exit;
        }

        $photoId = (int) $id;
        $userId = (int) $_SESSION['user_id'];

        $photo = $this->photoModel->getByIdAndUser(
            $photoId,
            $userId
        );

        if (!$photo) {
            http_response_code(403);
            echo 'You are not allowed to edit this photo.';
            return;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($title === '') {
            die('Title is required.');
        }

        if (strlen($title) > 200) {
            die('Title cannot exceed 200 characters.');
        }

        if (strlen($description) > 5000) {
            die('Description cannot exceed 5000 characters.');
        }

        $updated = $this->photoModel->update(
            $photoId,
            $userId,
            $title,
            $description
        );

        if (!$updated) {
            die('Failed to update photo.');
        }

        header(
            'Location: /alzikrayat/public/photos/' .
            $photoId
        );
        exit;
    }
}