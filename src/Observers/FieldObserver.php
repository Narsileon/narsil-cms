<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldObserver
{
    #region PUBLIC METHODS

    /**
     * @param Field $model
     *
     * @return void
     */
    public function retrieved(Field $model): void
    {
        if ($contract = $model->{Field::TYPE})
        {
            app($contract)::bootTranslations();
        }
    }

    #endregion
}
