<?php

namespace Narsil\Http\Requests\Users;

#region USE

use Narsil\Contracts\FormRequests\FormRequest as Contract;
use Narsil\Enums\SessionEnum;
use Narsil\Validation\FormRule;
use Illuminate\Foundation\Http\FormRequest;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SessionFormRequest extends FormRequest implements Contract
{
    #region CONSTANTS

    /**
     * @var string The name of the "type" parameter.
     */
    public const TYPE = 'type';

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            self::TYPE => [
                FormRule::STRING,
                FormRule::enum(SessionEnum::class),
            ],
        ];
    }

    #endregion
}
