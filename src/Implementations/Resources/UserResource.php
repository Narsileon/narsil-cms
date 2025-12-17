<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Narsil\Contracts\Resources\UserResource as Contract;
use Narsil\Implementations\AbstractResource;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserResource extends AbstractResource implements Contract
{
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
