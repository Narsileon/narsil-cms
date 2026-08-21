<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Narsil\Base\Implementations\FormRequest;
use Narsil\Base\Validation\FormRule;
use Narsil\Cms\Contracts\Requests\RedirectFormRequest as Contract;
use Narsil\Cms\Models\Redirect;

#endregion

class RedirectFormRequest extends FormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Redirect::URL_DESTINATION => [
                FormRule::REQUIRED,
                FormRule::STRING,
            ],
            Redirect::URL_SOURCE => [
                FormRule::REQUIRED,
                FormRule::STRING,
                FormRule::unique(Redirect::class, Redirect::URL_SOURCE)->ignore($this->redirect?->{Redirect::ID}),
            ],
            Redirect::STATUS_CODE => [
                FormRule::INTEGER,
                FormRule::REQUIRED,
                'in:301,302,307,308',
            ],
        ];
    }

    #endregion
}
