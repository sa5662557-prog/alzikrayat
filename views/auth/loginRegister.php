<?php

$lastLogin = $lastLogin ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alzikrayat - Login & Register</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/alzikrayat/public/">
            Alzikrayat
        </a>

        <div class="ms-auto">
            <a
                href="/alzikrayat/public/?page=auth"
                class="btn btn-outline-light"
            >
                Login / Register
            </a>
        </div>
    </div>
</nav>

<main class="container py-5">

    <div class="row g-4">

        <!-- Login -->
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h2 class="card-title mb-4">
                        Login
                    </h2>

                    <?php if ($lastLogin): ?>

                        <div class="alert alert-info">
                            Last login from this computer was
                            <?= htmlspecialchars($lastLogin, ENT_QUOTES, 'UTF-8') ?>
                        </div>

                    <?php endif; ?>

                    <form
                        action="/alzikrayat/public/auth/login"
                        method="POST"
                        id="loginForm"
                        novalidate
                    >

                        <div class="mb-3">
                            <label
                                for="loginEmail"
                                class="form-label"
                            >
                                Email
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="loginEmail"
                                name="email"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label
                                for="loginPassword"
                                class="form-label"
                            >
                                Password
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="loginPassword"
                                name="password"
                                minlength="8"
                                required
                            >
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Login
                        </button>

                    </form>

                </div>
            </div>

        </div>

        <!-- Register -->
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h2 class="card-title mb-4">
                        Create Account
                    </h2>

                    <form
                        action="/alzikrayat/public/auth/register"
                        method="POST"
                        id="registerForm"
                        novalidate
                    >

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label
                                    for="firstName"
                                    class="form-label"
                                >
                                    First Name
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="firstName"
                                    name="first_name"
                                    maxlength="50"
                                    pattern="[A-Za-z]+"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label
                                    for="lastName"
                                    class="form-label"
                                >
                                    Last Name
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="lastName"
                                    name="last_name"
                                    maxlength="50"
                                    pattern="[A-Za-z]+"
                                    required
                                >
                            </div>

                        </div>

                        <div class="mb-3">
                            <label
                                for="registerEmail"
                                class="form-label"
                            >
                                Email
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="registerEmail"
                                name="email"
                                maxlength="100"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label
                                for="registerPassword"
                                class="form-label"
                            >
                                Password
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="registerPassword"
                                name="password"
                                minlength="8"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label
                                for="location"
                                class="form-label"
                            >
                                Location
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="location"
                                name="location"
                                maxlength="100"
                            >
                        </div>

                        <div class="mb-3">
                            <label
                                for="occupation"
                                class="form-label"
                            >
                                Occupation
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="occupation"
                                name="occupation"
                                maxlength="100"
                            >
                        </div>

                        <div class="mb-3">
                            <label
                                for="description"
                                class="form-label"
                            >
                                About You
                            </label>

                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                rows="3"
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-success w-100"
                        >
                            Register
                        </button>

                    </form>

                </div>
            </div>

        </div>

    </div>

</main>

<script>
    document
        .getElementById('registerForm')
        .addEventListener('submit', function (event) {

            const firstName =
                document.getElementById('firstName').value.trim();

            const lastName =
                document.getElementById('lastName').value.trim();

            if (!/^[A-Za-z]+$/.test(firstName)) {
                event.preventDefault();
                alert('First name must contain letters only.');
                return;
            }

            if (!/^[A-Za-z]+$/.test(lastName)) {
                event.preventDefault();
                alert('Last name must contain letters only.');
            }
        });
</script>

</body>
</html>