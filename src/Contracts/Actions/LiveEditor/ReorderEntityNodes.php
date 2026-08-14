<?php

declare(strict_types=1);

namespace Narsil\Cms\Contracts\Actions\LiveEditor;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Entities\EntityNode;

#endregion

/**
 * @author Jonathan Rigaux
 *
 * @see vendor/narsil/cms/src/ServiceProvider.php
 */
interface ReorderEntityNodes extends Action
{
    #region PUBLIC METHODS

    /**
     * @param EntityNode $parent
     * @param array $orderedUuids
     *
     * @return void
     */
    public function run(EntityNode $parent, array $orderedUuids): void;

    #endregion
}
