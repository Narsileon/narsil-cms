<?php

namespace Narsil\Http\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class AuthResource extends JsonResource
{
    #region CONSTRUCTOR

    /**
     * @param User $resource
     *
     * @return void
     */
    public function __construct(User $resource)
    {
        parent::__construct($resource);
    }

    #endregion

    #region PROPERTIES

    public static $wrap = false;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            User::AVATAR => $this->{User::AVATAR},
            User::EMAIL => $this->{User::EMAIL},
            User::FIRST_NAME => $this->{User::FIRST_NAME},
            User::LAST_NAME => $this->{User::LAST_NAME},
            User::TWO_FACTOR_CONFIRMED_AT => $this->{User::TWO_FACTOR_CONFIRMED_AT},
        ];
    }

    #endregion
}
