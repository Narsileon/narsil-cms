<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Actions\Fields;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldBlocks as Contract;
use Narsil\Cms\Models\Collections\Field;

#endregion

class SyncFieldBlocks extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Field $field, array $blocks): Field
    {
        $field
            ->blocks()
            ->sync($blocks);

        return $field;
    }

    #endregion
}
