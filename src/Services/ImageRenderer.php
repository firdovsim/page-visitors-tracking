<?php

namespace App\Services;

class ImageRenderer
{
    public function renderImage(): void
    {
        header('Content-Type: image/jpeg');
        readfile('image.jpeg');
    }
}