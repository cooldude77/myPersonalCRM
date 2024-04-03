<?php

namespace App\Service\File\Interfaces;



interface FileDirectoryPathNamerInterface
{
    public function getFileFullPathImage(array $params): string;
}