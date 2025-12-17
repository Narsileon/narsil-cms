<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\RoleFormRequest as Contract;
use Narsil\Models\Sites\Site;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [
            Site::FOOTER_ID => [
                FormRule::INTEGER,
                FormRule::NULLABLE,
            ],
            Site::HEADER_ID => [
                FormRule::INTEGER,
                FormRule::NULLABLE,
            ],
            Site::RELATION_PAGES => [
                FormRule::ARRAY,
            ],
        ];
    }

    #endregion
}
