<?php

namespace App\Service\Admin\SideBar;

class PanelSideBarListMap
{
    private array $SideBarList;

    public function __construct(array $SideBarList)
    {

        $this->SideBarList = $SideBarList;
    }

    public function getSideBarList(): array
    {
        return $this->SideBarList;
    }


}