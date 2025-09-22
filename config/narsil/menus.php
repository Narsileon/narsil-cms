<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Menu Implementations
    |--------------------------------------------------------------------------
    |
    | This file defines a mapping between component contracts and their concrete implementations.
    |
    */

    \Narsil\Contracts\Menus\AuthMenu::class => \Narsil\Implementations\Menus\AuthMenu::class,
    \Narsil\Contracts\Menus\GuestMenu::class => \Narsil\Implementations\Menus\GuestMenu::class,
    \Narsil\Contracts\Menus\Sidebar::class => \Narsil\Implementations\Menus\Sidebar::class,
];
