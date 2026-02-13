<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Implementations\FormRequest;
use Narsil\Base\Validation\FormRule;
use Narsil\Cms\Contracts\Requests\SiteFormRequest as Contract;
use Narsil\Cms\Models\Sites\Site;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteFormRequest extends FormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->site)
        {
            return Gate::allows(AbilityEnum::UPDATE, $this->site);
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
