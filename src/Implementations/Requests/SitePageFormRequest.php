<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Implementations\FormRequest;
use Narsil\Cms\Contracts\Requests\SitePageFormRequest as Contract;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Services\Sites\SitePageFormRules;

#endregion

class SitePageFormRequest extends FormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->sitePage)
        {
            return Gate::allows(AbilityEnum::UPDATE, $this->sitePage);
        }

        return Gate::allows(AbilityEnum::CREATE, SitePage::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return app(SitePageFormRules::class)->forPage($this->sitePage ?? null);
    }

    #endregion
}
