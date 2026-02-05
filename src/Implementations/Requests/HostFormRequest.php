<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Cms\Contracts\FormRequests\HostFormRequest as Contract;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Implementations\AbstractFormRequest;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->host)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->host);
        }

        return Gate::allows(PermissionEnum::CREATE, Host::class);
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
