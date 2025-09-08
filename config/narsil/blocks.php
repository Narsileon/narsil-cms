<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Component Implementations
    |--------------------------------------------------------------------------
    |
    | This file defines a mapping between component contracts and their concrete implementations.
    |
    */

    \Narsil\Contracts\Blocks\AuthMenu::class => \Narsil\Implementations\Blocks\AuthMenu::class,
    \Narsil\Contracts\Blocks\GuestMenu::class => \Narsil\Implementations\Blocks\GuestMenu::class,
    \Narsil\Contracts\Blocks\Sidebar::class => \Narsil\Implementations\Blocks\Sidebar::class,
];
