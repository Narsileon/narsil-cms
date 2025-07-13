<?php

namespace App\Http\Forms\Resources;

#region USE

use App\Http\Forms\AbstractForm;
use App\Interfaces\Forms\Resources\ISiteGroupForm;
use App\Models\SiteGroup;
use App\Structures\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteGroupForm extends AbstractForm implements ISiteGroupForm
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getInputs(): array
    {
        return [
            (new Input(SiteGroup::NAME, ''))
                ->required(true)
                ->get(),
        ];
    }

    #endregion
}
