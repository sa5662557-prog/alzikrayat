<?php

$pageTitle = 'Alzikrayat - Edit Photo';

require __DIR__ . '/../layout/header.php';
?>

<main class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h1 class="fw-bold mb-1">
                        Edit Photo
                    </h1>

                    <p class="text-muted mb-0">
                        Update your photo title and description.
                    </p>
                </div>

                <a
                    href="/alzikrayat/public/photos/<?= (int) $photo['id'] ?>"
                    class="btn btn-outline-secondary"
                >
                    Cancel
                </a>

            </div>


            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <div class="text-center mb-4">

                        <img
                            src="/alzikrayat/public/images/uploads/<?= htmlspecialchars(
                                $photo['file_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            alt="<?= htmlspecialchars(
                                $photo['title'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            class="img-fluid rounded"
                            style="max-height: 400px; object-fit: contain;"
                        >

                    </div>


                    <form
                        action="/alzikrayat/public/photos/<?= (int) $photo['id'] ?>/update"
                        method="POST"
                    >

                        <div class="mb-3">

                            <label
                                for="title"
                                class="form-label fw-semibold"
                            >
                                Photo Title
                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                class="form-control"
                                value="<?= htmlspecialchars(
                                    $photo['title'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                                maxlength="200"
                                required
                            >

                        </div>


                        <div class="mb-4">

                            <label
                                for="description"
                                class="form-label fw-semibold"
                            >
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                class="form-control"
                                rows="6"
                                maxlength="5000"
                            ><?= htmlspecialchars(
                                $photo['description'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?></textarea>

                        </div>


                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Save Changes
                            </button>

                            <a
                                href="/alzikrayat/public/photos/<?= (int) $photo['id'] ?>"
                                class="btn btn-secondary"
                            >
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</main>


<?php

require __DIR__ . '/../layout/footer.php';
?>