<?php

declare(strict_types=1);

namespace Narsil\Cms\Services;

abstract class FieldService
{
    #region PUBLIC METHODS

    /**
     * Get the icon of the field.
     *
     * @param string $type
     *
     * @return string
     */
    public static function getIcon(string $type): string
    {
        return match ($type)
        {
            'asset', 'file' => 'fa-regular-file-lines',
            'builder' => 'fa-solid-cubes-stacked',
            'checkbox' => 'fa-regular-square-check',
            'color', 'icon' => 'fa-solid-palette',
            'date', 'datetime-local', 'month', 'week' => 'fa-regular-calendar',
            'email' => 'fa-regular-envelope',
            'entity', 'relations' => 'fa-solid-sitemap',
            'form' => 'fa-solid-clipboard-list',
            'link' => 'fa-solid-link',
            'number' => 'fa-solid-hashtag',
            'password' => 'fa-solid-key',
            'radio' => 'fa-regular-circle-dot',
            'range' => 'fa-solid-sliders',
            'rich-text' => 'fa-solid-spell-check',
            'select', 'combobox' => 'fa-solid-list',
            'switch' => 'fa-solid-toggle-on',
            'table' => 'fa-solid-table-columns',
            'text', 'textarea' => 'fa-solid-font',
            'time' => 'fa-regular-clock',
            default => 'fa-solid-circle-question',
        };
    }

    #endregion
}
