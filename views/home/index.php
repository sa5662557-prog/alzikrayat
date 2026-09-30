<?php

$pageTitle = 'Alzikrayat - Share Your Memories';

require __DIR__ . '/../layout/header.php';
?>

<main>

    <!-- Hero Section -->
    <section class="bg-light py-5">

        <div class="container">

            <div class="row align-items-center g-5">

                <div class="col-lg-6">

                    <span class="badge bg-primary mb-3">
                        Welcome to Alzikrayat
                    </span>

                    <h1 class="display-4 fw-bold">
                        Keep Your Memories Alive
                    </h1>

                    <p class="lead mt-3">
                        Alzikrayat is a photo sharing application
                        designed to help people preserve,
                        organize, and share their special memories.
                    </p>

                    <div class="mt-4">

                        <a
                            href="/alzikrayat/public/auth/register"
                            class="btn btn-primary btn-lg me-2"
                        >
                            Create Account
                        </a>

                        <a
                            href="/alzikrayat/public/auth"
                            class="btn btn-outline-dark btn-lg"
                        >
                            Login
                        </a>

                    </div>

                </div>


                <div class="col-lg-6">

                    <img
                        src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1000&q=80"
                        alt="Beautiful memory landscape"
                        class="img-fluid rounded-4 shadow"
                    >

                </div>

            </div>

        </div>

    </section>


    <!-- Statistics -->
    <section class="py-5">

        <div class="container">

            <div class="row text-center g-4">

                <div class="col-md-4">

                    <div class="card h-100 border-0 shadow-sm">

                        <div class="card-body py-4">

                            <h2 class="display-6 fw-bold">
                               <?= (int) $totalPhotos ?>
                            </h2>

                            <p class="mb-0 text-muted">
                                Photos Shared
                            </p>

                        </div>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="card h-100 border-0 shadow-sm">

                        <div class="card-body py-4">

                            <h2 class="display-6 fw-bold">
                                <?= (int) $totalUsers ?>
                            </h2>

                            <p class="mb-0 text-muted">
                                Registered Users
                            </p>

                        </div>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="card h-100 border-0 shadow-sm">

                        <div class="card-body py-4">

                            <h2 class="display-6 fw-bold">
                                <?= (int) $totalComments ?>
                            </h2>

                            <p class="mb-0 text-muted">
                              Comments
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- About Us -->
    <section
        id="about"
        class="bg-light py-5"
    >

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-9 text-center">

                    <h2 class="fw-bold mb-4">
                        About Us
                    </h2>

                    <p class="lead">
                        Alzikrayat is a photo sharing platform
                        created to provide a simple and organized
                        way for users to preserve their favorite
                        memories.
                    </p>

                    <p>
                        Users can create an account, share photos,
                        view memories, and interact through comments.
                        The application focuses on a responsive,
                        user-friendly experience while applying
                        secure authentication and database practices.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- Features -->
    <section class="py-5">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="fw-bold">
                    What You Can Do
                </h2>

                <p class="text-muted">
                    Explore the main features of Alzikrayat.
                </p>

            </div>


            <div class="row g-4">

                <div class="col-md-4">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="card-body text-center p-4">

                            <h3 class="h5">
                                Share Photos
                            </h3>

                            <p class="text-muted">
                                Upload and preserve your favorite
                                moments in your personal gallery.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="card-body text-center p-4">

                            <h3 class="h5">
                                Organize Memories
                            </h3>

                            <p class="text-muted">
                                Browse your memories through a
                                clean and responsive gallery.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="card-body text-center p-4">

                            <h3 class="h5">
                                Comment & Connect
                            </h3>

                            <p class="text-muted">
                                Interact with other users by adding
                                comments to shared photos.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</main>


<?php

require __DIR__ . '/../layout/footer.php';
?>