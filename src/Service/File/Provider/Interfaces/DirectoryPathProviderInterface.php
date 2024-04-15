<?php

namespace App\Service\File\Provider\Interfaces;



interface DirectoryPathProviderInterface
{
    public function getBaseFolderPath(): string;
}