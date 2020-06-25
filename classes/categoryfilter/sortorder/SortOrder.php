<?php

namespace Voilaah\MallApi\Classes\CategoryFilter\SortOrder;

use OFFLINE\Mall\Models\Currency;
use Illuminate\Support\Collection;
use Voilaah\MallApi\Classes\CategoryFilter\SortOrder\NameAsc;
use Voilaah\MallApi\Classes\CategoryFilter\SortOrder\NameDesc;
use OFFLINE\Mall\Classes\CategoryFilter\SortOrder\SortOrder as MallSortOrder;

abstract class SortOrder extends MallSortOrder
{

    /**
     * These are all available options. Internal options
     * are not meant to be used by a customer.
     *
     * @param bool $excludeInternal
     *
     * @return array
     */
    public static function options($excludeInternal = false)
    {
        $options = [
            'name_asc'       => new NameAsc(),
            'name_desc'       => new NameDesc(),
        ];

        return array_merge(parent::options(), $options );

    }


    /**
     * Get a SortOrder instance from $key.
     *
     * @param string $key
     *
     * @return SortOrder
     */
    public static function fromKey(string $key): MallSortOrder
    {
        $options = self::options();
        if ( ! array_key_exists($key, $options)) {
            return $options[self::default()];
        }

        return $options[$key];
    }
}
