<?php

namespace App\Http\Resources\Inertia;

#region USE

use App\Models\User;
use App\Models\Users\UserConfiguration;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserInertiaResource extends JsonResource
{
    #region CONSTRUCTOR

    /**
     * @param User|null $resource
     *
     * @return void
     */
    public function __construct(User|null $resource = null)
    {
        if (!$resource)
        {
            $resource = Auth::user();
        }

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
        return $this->resource ? [
            User::EMAIL => $this->{User::EMAIL},
            User::FIRST_NAME => $this->{User::FIRST_NAME},
            User::LAST_NAME => $this->{User::LAST_NAME},
            User::TWO_FACTOR_CONFIRMED_AT => $this->{User::TWO_FACTOR_CONFIRMED_AT},

            User::RELATION_CONFIGURATION => [
                UserConfiguration::COLOR => $this->{User::RELATION_CONFIGURATION}->{UserConfiguration::COLOR},
                UserConfiguration::RADIUS => $this->{User::RELATION_CONFIGURATION}->{UserConfiguration::RADIUS},
                UserConfiguration::THEME => $this->{User::RELATION_CONFIGURATION}->{UserConfiguration::THEME},
            ],
        ] : [];
    }

    #endregion
}
