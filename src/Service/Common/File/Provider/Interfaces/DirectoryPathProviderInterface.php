<?php

namespace App\Service\Common\File\Provider\Interfaces;



interface DirectoryPathProviderInterface
{
    public function getBaseFolderPath(): string;
}