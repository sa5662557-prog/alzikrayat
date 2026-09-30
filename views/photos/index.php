<?php

$pageTitle = 'Alzikrayat - Photo Gallery';

require __DIR__ . '/../layout/header.php';
?>

<main class="container py-5">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

        <div>
            <h1 class="fw-bold mb-1">
                Photo Gallery
            </h1>

            <p class="text-muted mb-0">
                Explore memories shared by Alzikrayat users.
            </p>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>

            <a
                href="/alzikrayat/public/photos/create"
                class="btn btn-primary mt-3 mt-md-0"
            >
                Add Photo
            </a>

        <?php endif; ?>

    </div>


    <?php if (empty($photos)): ?>

        <div class="alert alert-info text-center">
            No photos have been shared yet.
        </div>

        <?php else: ?>

        <div class="gallery-toolbar mb-4">

            <div>
                <span class="fw-semibold">
                    Viewing Style:
                </span>
            </div>

            <div class="btn-group" role="group">

    <button
        type="button"
        class="btn btn-outline-primary active"
        data-view="three-column"
    >
        3 Columns
    </button>

    <button
        type="button"
        class="btn btn-outline-primary"
        data-view="four-column"
    >
        4 Columns
    </button>

    <button
        type="button"
        class="btn btn-outline-primary"
        data-view="list"
    >
        List
    </button>

    <button
        type="button"
        class="btn btn-outline-primary"
        data-view="slider"
    >
        Slider
    </button>

</div>
        </div>


        <div
    id="photoGallery"
    class="photo-gallery gallery-three-column"
>

            <?php foreach ($photos as $photo): ?>

                                <div class="gallery-item">

                    <div class="card h-100 shadow-sm">

                        <img
                            src="/alzikrayat/public/images/uploads/<?= htmlspecialchars(
                                $photo['file_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            class="card-img-top gallery-image"
                            alt="<?= htmlspecialchars(
                                $photo['title'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            style="height: 250px; object-fit: cover;"
                        >


                        <div class="card-body d-flex flex-column">

                            <h2 class="h5 card-title">

                                <?= htmlspecialchars(
                                    $photo['title'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </h2>


                            <?php if (!empty($photo['description'])): ?>

                                <p class="card-text text-muted">

                                    <?= htmlspecialchars(
                                        $photo['description'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </p>

                            <?php endif; ?>


                            <p class="small text-muted mb-3">

                                By
                                <?= htmlspecialchars(
                                    $photo['first_name'] . ' ' . $photo['last_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                                <br>

                                <?= htmlspecialchars(
                                    $photo['date_time'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </p>


                            <a
                                href="/alzikrayat/public/photos/<?= (int) $photo['id'] ?>"
                                class="btn btn-outline-primary mt-auto"
                            >
                                View Details
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const gallery = document.getElementById('photoGallery');

    const buttons = document.querySelectorAll(
        '[data-view]'
    );

    buttons.forEach(function (button) {

        button.addEventListener('click', function () {

            const view = this.dataset.view;

            gallery.classList.remove(
    'gallery-three-column',
    'gallery-four-column',
    'gallery-list',
    'gallery-slider'
);

            gallery.classList.add(
                'gallery-' + view
            );

            buttons.forEach(function (btn) {
                btn.classList.remove('active');
            });

            this.classList.add('active');

        });

    });

});
</script>
</main>


<?php

require __DIR__ . '/../layout/footer.php';
?>