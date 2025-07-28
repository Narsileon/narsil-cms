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

    \Narsil\Contracts\Components\AuthMenu::class => \Narsil\Implementations\Components\AuthMenu::class,
    \Narsil\Contracts\Components\GuestMenu::class => \Narsil\Implementations\Components\GuestMenu::class,
    \Narsil\Contracts\Components\Sidebar::class => \Narsil\Implementations\Components\Sidebar::class,
];
