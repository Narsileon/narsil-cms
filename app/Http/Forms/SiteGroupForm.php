<?php

namespace App\Http\Forms;

#region USE

use App\Models\SiteGroup;
use App\Structures\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteGroupForm extends AbstractForm
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected static function inputs(): array
    {
        return [
            (new Input(SiteGroup::NAME))
                ->required(true)
                ->get(),
        ];
    }

    #endregion
}
