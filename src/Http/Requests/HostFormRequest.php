<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\HostFormRequest as Contract;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [
            Host::HANDLE => [
                ...FormRule::getSlugRules(),
                FormRule::REQUIRED,
                FormRule::unique(
                    Host::class,
                    Host::HANDLE,
                )->ignore($model?->{Host::ID}),
            ],
            Host::NAME => [
                FormRule::REQUIRED,
            ],

            Host::RELATION_LOCALES => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Host::RELATION_LOCALES . '.*.' . HostLocale::COUNTRY => [
                FormRule::STRING,
                FormRule::NULLABLE,
            ],
            Host::RELATION_LOCALES . '.*.' . HostLocale::UUID => [
                FormRule::STRING,
                FormRule::SOMETIMES,
            ],
            Host::RELATION_LOCALES . '.*.' . HostLocale::PATTERN => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Host::RELATION_LOCALES . '.*.' . HostLocale::RELATION_LANGUAGES => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
            Host::RELATION_LOCALES . '.*.' . HostLocale::RELATION_LANGUAGES . '.*.' . HostLocaleLanguage::UUID => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Host::RELATION_LOCALES . '.*.' . HostLocale::RELATION_LANGUAGES . '.*.' . HostLocaleLanguage::LANGUAGE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
