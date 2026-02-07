<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Cms\Contracts\Requests\RoleFormRequest as Contract;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Implementations\AbstractFormRequest;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->site)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->site);
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
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
