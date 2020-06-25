<?php

namespace Voilaah\MallApi\Classes\CategoryFilter\SortOrder;

use OFFLINE\Mall\Classes\CategoryFilter\SortOrder\SortOrder;

class NameDesc extends SortOrder
{
    public function key(): string
    {
        return 'name_desc';
    }

    public function property(): string
    {
        return 'name';
    }

    public function direction(): string
    {trace_log('here');
        return 'desc';
    }
}
