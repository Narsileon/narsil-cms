<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Implementations\FormRequest;
use Narsil\Base\Validation\FormRule;
use Narsil\Cms\Contracts\Requests\HostFormRequest as Contract;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostFormRequest extends FormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->host)
        {
            return Gate::allows(AbilityEnum::UPDATE, $this->host);
        }

        return Gate::allows(AbilityEnum::CREATE, Host::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Host::HOSTNAME => [
                FormRule::LOWERCASE,
                FormRule::STRING,
                FormRule::REQUIRED,
                FormRule::unique(
                    Host::class,
                    Host::HOSTNAME,
                )->ignore($this->host?->{Host::ID}),
            ],
            Host::LABEL => [
                FormRule::REQUIRED,
            ],

            Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::PATTERN => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::RELATION_LANGUAGES => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],

            Host::RELATION_OTHER_LOCALES => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Host::RELATION_OTHER_LOCALES . '.*.' . HostLocale::COUNTRY => [
                FormRule::STRING,
                FormRule::NULLABLE,
            ],
            Host::RELATION_OTHER_LOCALES . '.*.' . HostLocale::UUID => [
                FormRule::STRING,
                FormRule::SOMETIMES,
            ],
            Host::RELATION_OTHER_LOCALES . '.*.' . HostLocale::PATTERN => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Host::RELATION_OTHER_LOCALES . '.*.' . HostLocale::RELATION_LANGUAGES => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
            Host::RELATION_OTHER_LOCALES . '.*.' . HostLocale::RELATION_LANGUAGES . '.*.' . HostLocaleLanguage::UUID => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Host::RELATION_OTHER_LOCALES . '.*.' . HostLocale::RELATION_LANGUAGES . '.*.' . HostLocaleLanguage::LANGUAGE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
