<?php

$lastLogin = $lastLogin ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Alzikrayat - Login</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container">

        <a
            class="navbar-brand"
            href="/alzikrayat/public/"
        >
            Alzikrayat
        </a>

    </div>
</nav>


<main class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <h1 class="text-center mb-4">
                        Login
                    </h1>


                    <?php if ($lastLogin): ?>

                        <div class="alert alert-info">
                            Last login:
                            <?= htmlspecialchars(
                                $lastLogin,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
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


                    <hr class="my-4">


                    <p class="text-center mb-0">

                        Don't have an account?

                        <a
                            href="/alzikrayat/public/auth/register"
                        >
                            Register
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</main>


<script>

document
    .getElementById('loginForm')
    .addEventListener('submit', function (event) {

        const email =
            document.getElementById('loginEmail').value.trim();

        const password =
            document.getElementById('loginPassword').value;

        if (email === '') {

            event.preventDefault();

            alert('Email is required.');

            return;
        }

        if (password.length < 8) {

            event.preventDefault();

            alert('Password must be at least 8 characters long.');

            return;
        }

    });

</script>

</body>

</html>