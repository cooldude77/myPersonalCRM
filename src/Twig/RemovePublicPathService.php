<?php

namespace App\Twig;

use App\Service\File\Interfaces\DirectoryPathProviderInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class RemovePublicPathService extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new TwigFilter('removePublicPathSegment', [$this, 'removePublicPathSegment']),
        ];
    }

    public function removePublicPathSegment($path): string
    {
        return substr($path, strlen('/public/'),strlen($path) );
    }
}