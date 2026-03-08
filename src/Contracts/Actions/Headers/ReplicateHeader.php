<?php

namespace Narsil\Cms\Contracts\Actions\Headers;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Globals\Header;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface ReplicateHeader extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Header $header
     *
     * @return Header
     */
    public function run(Header $header): Header;

    #endregion
}
