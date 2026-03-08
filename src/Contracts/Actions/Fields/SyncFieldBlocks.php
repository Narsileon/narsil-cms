<?php

namespace Narsil\Cms\Contracts\Actions\Fields;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface SyncFieldBlocks extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Field $field
     * @param integer[] $blocks
     *
     * @return Field
     */
    public function run(Field $field, array $blocks): Field;

    #endregion
}
