<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Menu Bindings
    |--------------------------------------------------------------------------
    |
    | Mapping between component contracts and their concrete implementations.
    |
    */

    \Narsil\Cms\Contracts\Menus\AuthMenu::class => \Narsil\Cms\Implementations\Menus\AuthMenu::class,
    \Narsil\Cms\Contracts\Menus\GuestMenu::class => \Narsil\Cms\Implementations\Menus\GuestMenu::class,
    \Narsil\Cms\Contracts\Menus\Sidebar::class => \Narsil\Cms\Implementations\Menus\Sidebar::class,
];
