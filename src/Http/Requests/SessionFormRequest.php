<?php

namespace Narsil\Http\Requests;

#region USE

use Narsil\Enums\Database\SessionEnum;
use Narsil\Validation\FormRule;
use Illuminate\Foundation\Http\FormRequest;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SessionFormRequest extends FormRequest
{
    #region CONSTANTS

    /**
     * The name of the "type" parameter.
     *
     * @var string
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
