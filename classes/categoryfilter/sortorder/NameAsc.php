<?php

namespace Voilaah\MallApi\Classes\CategoryFilter\SortOrder;

use OFFLINE\Mall\Classes\CategoryFilter\SortOrder\SortOrder;

class NameAsc extends SortOrder
{
    public function key(): string
    {
        return 'name_asc';
    }

    public function property(): string
    {
        return 'name';
    }

    public function direction(): string
    {
        return 'asc';
    }
}
