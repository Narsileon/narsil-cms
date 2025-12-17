<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\File;
use Narsil\Contracts\FormRequests\HeaderFormRequest as Contract;
use Narsil\Models\Globals\Header;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [
            Header::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Header::class,
                    Header::HANDLE,
                )->ignore($model?->{Header::ID}),
            ],
            Header::LOGO => [
                File::image()
                    ->dimensions(
                        FormRule::dimensions()
                            ->maxWidth(2048)
                            ->maxHeight(2048)
                    ),
                FormRule::NULLABLE,
            ],
        ];
    }

    #endregion
}
