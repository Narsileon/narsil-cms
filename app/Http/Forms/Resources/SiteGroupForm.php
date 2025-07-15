<?php

namespace App\Http\Forms\Resources;

#region USE

use App\Contracts\Forms\Resources\SiteGroupForm as Contract;
use App\Enums\Forms\TypeEnum;
use App\Http\Forms\AbstractForm;
use App\Models\SiteGroup;
use App\Support\Forms\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteGroupForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getContent(): array
    {
        return [
            (new Input(SiteGroup::NAME, TypeEnum::TEXT, ''))
                ->setRequired(true)
                ->get(),
        ];
    }

    #endregion
}
