<?php

$pageTitle = 'Alzikrayat - Photo Details';

require __DIR__ . '/../layout/header.php';
?>

<main class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <a
                href="/alzikrayat/public/photos"
                class="btn btn-outline-secondary mb-4"
            >
                ← Back to Gallery
            </a>

            <div class="card shadow-sm overflow-hidden">

                <img
                    src="/alzikrayat/public/images/uploads/<?= htmlspecialchars(
                        $photo['file_name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    class="img-fluid w-100"
                    alt="<?= htmlspecialchars(
                        $photo['title'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    style="max-height: 650px; object-fit: contain;"
                >

                <div class="card-body p-4">

                    <h1 class="fw-bold mb-3">
                        <?= htmlspecialchars(
                            $photo['title'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </h1>

                    <p class="text-muted mb-2">
                        <strong>By:</strong>

                        <?= htmlspecialchars(
                            $photo['first_name'] . ' ' . $photo['last_name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>

                    <p class="text-muted mb-4">
                        <strong>Date:</strong>

                        <?= htmlspecialchars(
                            $photo['date_time'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>
                    <?php if (
    isset($_SESSION['user_id']) &&
    (int) $_SESSION['user_id'] === (int) $photo['user_id']
): ?>

    <form
        action="/alzikrayat/public/photos/<?= (int) $photo['id'] ?>/delete"
        method="POST"
        class="mb-4"
        onsubmit="return confirm('Are you sure you want to delete this photo?');"
    >

        <button
            type="submit"
            class="btn btn-danger"
        >
            Delete Photo
        </button>

    </form>

<?php endif; ?>

                    <?php if (!empty($photo['description'])): ?>

                        <div class="mb-5">

                            <h2 class="h5 fw-bold">
                                Description
                            </h2>

                            <p class="text-muted">
                                <?= nl2br(
                                    htmlspecialchars(
                                        $photo['description'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                ) ?>
                            </p>

                        </div>

                    <?php endif; ?>


                    <hr>


                    <section class="mt-4">

                        <h2 class="h4 fw-bold mb-4">
                            Comments
                        </h2>


                        <?php if (empty($comments)): ?>

                            <div class="alert alert-light border">
                                No comments yet.
                                Be the first to comment!
                            </div>

                        <?php else: ?>

                            <?php foreach ($comments as $comment): ?>

                                <div class="border rounded p-3 mb-3">

                                    <div class="d-flex justify-content-between">

                                        <strong>
                                            <?= htmlspecialchars(
                                                $comment['first_name'] .
                                                ' ' .
                                                $comment['last_name'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </strong>

                                        <small class="text-muted">
                                            <?= htmlspecialchars(
                                                $comment['date_time'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </small>

                                    </div>

                                    <p class="mb-0 mt-2">
                                        <?= nl2br(
                                            htmlspecialchars(
                                                $comment['comment'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                        ) ?>
                                    </p>

                                </div>

                            <?php endforeach; ?>

                        <?php endif; ?>


                        <?php if (!isset($_SESSION['user_id'])): ?>

                            <div class="alert alert-info mt-4">

                                Please
                                <a href="/alzikrayat/public/auth">
                                    log in
                                </a>
                                to add a comment.

                            </div>


                        <?php elseif ($canComment): ?>

                            <div class="card bg-light border-0 mt-4">

                                <div class="card-body">

                                    <h3 class="h5 fw-bold mb-3">
                                        Add a Comment
                                    </h3>

                                    <form
                                        action="/alzikrayat/public/photos/<?= (int) $photo['id'] ?>/comments"
                                        method="POST"
                                    >

                                        <div class="mb-3">

                                            <label
                                                for="comment"
                                                class="form-label"
                                            >
                                                Your Comment
                                            </label>

                                            <textarea
                                                id="comment"
                                                name="comment"
                                                class="form-control"
                                                rows="4"
                                                maxlength="1000"
                                                required
                                            ></textarea>

                                        </div>

                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                        >
                                            Submit Comment
                                        </button>

                                    </form>

                                </div>

                            </div>


                        <?php else: ?>

                            <div class="alert alert-secondary mt-4">
                                You have already commented on this photo.
                            </div>

                        <?php endif; ?>

                    </section>

                </div>

            </div>

        </div>

    </div>

</main>


<?php

require __DIR__ . '/../layout/footer.php';
?>