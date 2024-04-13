<?php

namespace App\Service\File\Provider\Interfaces;



interface DirectoryPathProviderInterface
{
    public function getFullPathForFiles(array $params): string;
}