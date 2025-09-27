<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\SiteFormRequest as Contract;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteSubdomain;
use Narsil\Models\Sites\SiteSubdomainLanguage;
use Narsil\Validation\FormRule;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
            Site::DOMAIN => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Site::NAME => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Site::PATTERN => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],

            Site::RELATION_SUBDOMAINS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Site::RELATION_SUBDOMAINS . '.*.' . SiteSubdomain::ID => [
                FormRule::INTEGER,
                FormRule::SOMETIMES,
            ],
            Site::RELATION_SUBDOMAINS . '.*.' . SiteSubdomain::SUBDOMAIN => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Site::RELATION_SUBDOMAINS . '.*.' . SiteSubdomain::RELATION_LANGUAGES => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
            Site::RELATION_SUBDOMAINS . '.*.' . SiteSubdomain::RELATION_LANGUAGES . '.*.' . SiteSubdomainLanguage::ID => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Site::RELATION_SUBDOMAINS . '.*.' . SiteSubdomain::RELATION_LANGUAGES . '.*.' . SiteSubdomainLanguage::LANGUAGE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
