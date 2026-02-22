<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model Tables
    |--------------------------------------------------------------------------
    |
    | Mapping between model tables and their tables.
    |
    */

    \Narsil\Cms\Models\Collections\Block::TABLE => \Narsil\Cms\Implementations\Tables\BlockTable::class,
    \Narsil\Cms\Models\Collections\Field::TABLE => \Narsil\Cms\Implementations\Tables\FieldTable::class,
    \Narsil\Cms\Models\Collections\Template::TABLE => \Narsil\Cms\Implementations\Tables\TemplateTable::class,
    \Narsil\Cms\Models\Entities\Entity::TABLE => \Narsil\Cms\Implementations\Tables\EntityTable::class,
    \Narsil\Cms\Models\Globals\Footer::TABLE => \Narsil\Cms\Implementations\Tables\FooterTable::class,
    \Narsil\Cms\Models\Globals\Header::TABLE => \Narsil\Cms\Implementations\Tables\HeaderTable::class,
    \Narsil\Cms\Models\Hosts\Host::TABLE => \Narsil\Cms\Implementations\Tables\HostTable::class,
];
