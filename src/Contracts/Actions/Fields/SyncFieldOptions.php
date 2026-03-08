<?php

namespace Narsil\Cms\Contracts\Actions\Fields;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface SyncFieldOptions extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Field $field
     * @param array $options
     *
     * @return Field
     */
    public function run(Field $field, array $options): Field;

    #endregion
}
