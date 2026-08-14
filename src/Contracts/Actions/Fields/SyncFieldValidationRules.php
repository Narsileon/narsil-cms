<?php

namespace Narsil\Cms\Contracts\Actions\Fields;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Collections\Field;

#endregion

interface SyncFieldValidationRules extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Field $field
     * @param integer[] $validationRules
     *
     * @return Field
     */
    public function run(Field $field, array $validationRules): Field;

    #endregion
}
