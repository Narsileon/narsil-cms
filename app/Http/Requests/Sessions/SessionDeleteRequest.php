<?php

namespace App\Http\Requests\Sessions;

#region USE

use App\Enums\SessionEnum;
use App\Http\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;

#endregion

class SessionDeleteRequest extends AbstractFormRequest
{
    #region CONSTANTS

    /**
     * @var string
     */
    public const TYPE = 'type';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            self::TYPE => [
                self::STRING,
                Rule::enum(SessionEnum::class),
            ],
        ];
    }

    #endregion
}
