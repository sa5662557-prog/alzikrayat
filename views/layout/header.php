<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$firstName = $_SESSION['first_name'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?= htmlspecialchars(
        $pageTitle ?? 'Alzikrayat',
        ENT_QUOTES,
        'UTF-8'
    ) ?></title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
<link
    rel="stylesheet"
    href="/alzikrayat/public/css/style.css"
>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">

    <div class="container">

        <a
            class="navbar-brand fw-bold"
            href="/alzikrayat/public/"
        >
            Alzikrayat
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div
            class="collapse navbar-collapse"
            id="mainNavigation"
        >

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="/alzikrayat/public/"
                    >
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="/alzikrayat/public/#about"
                    >
                        About Us
                    </a>
                </li>
<li class="nav-item">
    <a
        class="nav-link"
        href="/alzikrayat/public/photos"
    >
        Gallery
    </a>
</li>
                <?php if ($isLoggedIn): ?>

                    <li class="nav-item">
                        <span class="nav-link">
                            Hi <?= htmlspecialchars(
                                $firstName,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </span>
                    </li>

                    <li class="nav-item ms-lg-2">
                        <a
                            class="btn btn-danger btn-sm"
                            href="/alzikrayat/public/auth/logout"
                        >
                            Logout
                        </a>
                    </li>

                <?php else: ?>

                    <li class="nav-item ms-lg-2">
                        <a
                            class="btn btn-primary btn-sm"
                            href="/alzikrayat/public/auth"
                        >
                            Please Login
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</nav>