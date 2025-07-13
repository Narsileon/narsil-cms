<?php

namespace App\Http\Requests\Sessions;

#region USE

use App\Enums\SessionEnum;
use App\Validation\FormRule;
use Illuminate\Foundation\Http\FormRequest;
#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SessionDeleteRequest extends FormRequest
{
    #region CONSTANTS

    /**
     * @var string The name of the "type" parameter.
     */
    public const TYPE = 'type';

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
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
