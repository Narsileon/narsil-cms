<?php

namespace Narsil\Cms\Implementations\Actions\Headers;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Base\Services\DatabaseService;
use Narsil\Cms\Contracts\Actions\Headers\ReplicateHeader as Contract;
use Narsil\Cms\Models\Globals\Header;

#endregion

/**
 * @author Jonathan Rigaux
 */
class ReplicateHeader extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Header $header): Header
    {
        $replicated = $header->replicate();

        $replicated
            ->fill([
                Header::SLUG => DatabaseService::generateUniqueValue($replicated, Header::SLUG, $header->{Header::SLUG}),
            ])
            ->save();

        return $replicated;
    }

    #endregion
}
