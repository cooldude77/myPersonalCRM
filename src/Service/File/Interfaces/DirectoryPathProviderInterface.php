<?php

namespace App\Service\File\Interfaces;



interface DirectoryPathProviderInterface
{
    public function getFullPathForImages(array $params): string;
}