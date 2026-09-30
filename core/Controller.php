<?php

class Controller
{
    /**
     * Load a view file and pass data to it.
     *
     * @param string $viewPath The path of the view relative to the views directory.
     * @param array $data Data that will be available inside the view.
     * @return void
     * @throws Exception If the requested view file does not exist.
     */
    protected function view($viewPath, $data = [])
    {
        $fullPath = __DIR__ . '/../views/' . $viewPath . '.php';

        if (!file_exists($fullPath)) {
            throw new Exception("View file not found: " . $fullPath);
        }

        extract($data);

        require $fullPath;
    }
}