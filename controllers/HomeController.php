<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Statistics.php';

/**
 * Handles the Alzikrayat home page.
 */
class HomeController extends Controller
{
    /**
     * Displays the main Alzikrayat landing page.
     *
     * @return void
     */
    public function index()
    {
        $statistics = new Statistics();

        $this->view('home/index', [
            'totalUsers' => $statistics->getUsersCount(),
            'totalPhotos' => $statistics->getPhotosCount(),
            'totalComments' => $statistics->getCommentsCount()
        ]);
    }
}