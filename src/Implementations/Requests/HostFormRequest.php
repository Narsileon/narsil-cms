<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Contracts\FormRequests\HostFormRequest as Contract;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Implementations\AbstractFormRequest;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Validation\FormRule;

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
            Host::HANDLE => [
                FormRule::LOWERCASE,
                FormRule::STRING,
                FormRule::REQUIRED,
                FormRule::unique(
                    Host::class,
                    Host::HANDLE,
                )->ignore($this->host?->{Host::ID}),
            ],
            Host::NAME => [
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
