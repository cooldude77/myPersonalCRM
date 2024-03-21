<?php

namespace App\Service\File\Interfaces;

interface FileDirectoryPathNamerInterface
{
    public function getFileFullPath(array $params): string;
}