<?php

namespace Narsil\Cms\Implementations\Actions\Fields;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldValidationRules as Contract;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @author Jonathan Rigaux
 */
class SyncFieldValidationRules extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Field $field, array $validationRules): Field
    {
        $field
            ->validation_rules()
            ->sync($validationRules);

        return $field;
    }

    #endregion
}
