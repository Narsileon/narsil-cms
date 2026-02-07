<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Cms\Contracts\Requests\SitePageFormRequest as Contract;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Enums\SitePageAdapterEnum;
use Narsil\Cms\Implementations\AbstractFormRequest;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->sitePage)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->sitePage);
        }

        return Gate::allows(PermissionEnum::CREATE, SitePage::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        $rules = [
            SitePage::ADAPTER => [
                FormRule::enum(SitePageAdapterEnum::class),
            ],
            SitePage::CHANGE_FREQ => [
                FormRule::STRING,
            ],
            SitePage::COLLECTION => [
                FormRule::STRING,
                FormRule::NULLABLE,
            ],
            SitePage::META_DESCRIPTION => [
                FormRule::ARRAY,
            ],
            SitePage::PARENT_ID => [
                FormRule::INTEGER,
                FormRule::NULLABLE,
            ],
            SitePage::PRIORITY => [
                FormRule::NUMERIC,
            ],
            SitePage::OPEN_GRAPH_DESCRIPTION => [
                FormRule::ARRAY,
            ],
            SitePage::OPEN_GRAPH_TITLE => [
                FormRule::ARRAY,
            ],
            SitePage::OPEN_GRAPH_TYPE => [
                FormRule::STRING,
            ],
            SitePage::ROBOTS => [
                FormRule::STRING,
            ],
            SitePage::SHOW_IN_MENU => [
                FormRule::BOOLEAN,
                FormRule::REQUIRED,
            ],
            SitePage::SITE_ID => [
                FormRule::INTEGER,
                FormRule::REQUIRED,
            ],
            SitePage::SLUG => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
            SitePage::SLUG . '.*' => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
            ],
            SitePage::TITLE => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],

            SitePage::RELATION_ENTITIES => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
        ];

        if ($this->sitePage)
        {
            unset($rules[SitePage::PARENT_ID]);
        }

        return $rules;
    }

    #endregion
}
