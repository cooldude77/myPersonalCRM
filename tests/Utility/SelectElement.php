<?php

namespace App\Tests\Utility;

use Zenstruck\Browser;

trait SelectElement
{

    public function addOption(Browser $browser,string $filter, int $chosenValue):void
    {
        $domDocument = $browser->crawler()->getNode(0)?->parentNode;

        $option = $domDocument->createElement('option');
        $option->setAttribute('value', $chosenValue);
        $selectElement = $browser->crawler()->filter($filter)->getNode(0);
        $selectElement->appendChild($option);

    }
}