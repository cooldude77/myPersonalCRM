<?php

namespace App\Service\File\Interfaces;



interface FileDirectoryPathNamerInterface
{
    public function getFullPathForImages(array $params): string;
}