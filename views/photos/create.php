<?php

$pageTitle = 'Alzikrayat - Add Photo';

require __DIR__ . '/../layout/header.php';
?>

<main class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <h1 class="fw-bold mb-2">
                        Add New Photo
                    </h1>

                    <p class="text-muted mb-4">
                        Share a special memory with the Alzikrayat community.
                    </p>


                    <form
                        action="/alzikrayat/public/photos/store"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        <div class="mb-3">

                            <label
                                for="photo"
                                class="form-label"
                            >
                                Choose Photo
                            </label>

                            <input
                                type="file"
                                class="form-control"
                                id="photo"
                                name="photo"
                                accept="image/jpeg,image/png,image/gif"
                                required
                            >

                            <div class="form-text">
                                Allowed formats: JPG, PNG, GIF.
                                Maximum size: 5 MB.
                            </div>

                        </div>


                        <div class="mb-3">

                            <label
                                for="title"
                                class="form-label"
                            >
                                Title
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                name="title"
                                maxlength="150"
                                required
                            >

                        </div>


                        <div class="mb-4">

                            <label
                                for="description"
                                class="form-label"
                            >
                                Description
                            </label>

                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                rows="5"
                                maxlength="1000"
                            ></textarea>

                        </div>


                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Upload Photo
                            </button>

                            <a
                                href="/alzikrayat/public/photos"
                                class="btn btn-outline-secondary"
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