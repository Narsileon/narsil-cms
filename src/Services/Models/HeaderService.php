<?php

namespace Narsil\Services\Models;

#region USE

use Narsil\Models\Globals\Header;
use Narsil\Services\DatabaseService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class HeaderService
{
    #region PUBLIC METHODS

    /**
     * @param Header $header
     *
     * @return void
     */
    public static function replicate(Header $header): void
    {
        $replicated = $header->replicate();

        $replicated
            ->fill([
                Header::SLUG => DatabaseService::generateUniqueValue($replicated, Header::SLUG, $header->{Header::SLUG}),
            ])
            ->save();
    }

    #endregion
}
