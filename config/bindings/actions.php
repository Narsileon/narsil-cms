<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Action Bindings
    |--------------------------------------------------------------------------
    |
    | Mapping between form contracts and their implementations.
    |
    */

    \Narsil\Cms\Contracts\Actions\Blocks\ReplicateBlock::class => \Narsil\Cms\Implementations\Actions\Blocks\ReplicateBlock::class,
    \Narsil\Cms\Contracts\Actions\Blocks\SyncBlockElements::class => \Narsil\Cms\Implementations\Actions\Blocks\SyncBlockElements::class,
    \Narsil\Cms\Contracts\Actions\Elements\SyncElementConditions::class => \Narsil\Cms\Implementations\Actions\Elements\SyncElementConditions::class,
    \Narsil\Cms\Contracts\Actions\Fields\ReplicateField::class => \Narsil\Cms\Implementations\Actions\Fields\ReplicateField::class,
    \Narsil\Cms\Contracts\Actions\Fields\SyncFieldBlocks::class => \Narsil\Cms\Implementations\Actions\Fields\SyncFieldBlocks::class,
    \Narsil\Cms\Contracts\Actions\Fields\SyncFieldOptions::class => \Narsil\Cms\Implementations\Actions\Fields\SyncFieldOptions::class,
    \Narsil\Cms\Contracts\Actions\Fields\SyncFieldValidationRules::class => \Narsil\Cms\Implementations\Actions\Fields\SyncFieldValidationRules::class,
    \Narsil\Cms\Contracts\Actions\Headers\ReplicateHeader::class => \Narsil\Cms\Implementations\Actions\Headers\ReplicateHeader::class,
    \Narsil\Cms\Contracts\Actions\Templates\ReplicateTemplate::class => \Narsil\Cms\Implementations\Actions\Templates\ReplicateTemplate::class,
    \Narsil\Cms\Contracts\Actions\Templates\SyncTemplateTabs::class => \Narsil\Cms\Implementations\Actions\Templates\SyncTemplateTabs::class,
    \Narsil\Cms\Contracts\Actions\Templates\SyncTemplateTabElements::class => \Narsil\Cms\Implementations\Actions\Templates\SyncTemplateTabElements::class,
];
