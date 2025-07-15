<?php

namespace App\Actions\Fortify;

#region USE

use App\Contracts\FormRequests\Fortify\CreateNewUserFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CreateNewUser implements CreatesNewUsers
{
    #region CONSTRUCTOR

    /**
     * @param CreateNewUserFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(CreateNewUserFormRequest $formRequest)
    {
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var CreateNewUserFormRequest
     */
    protected readonly CreateNewUserFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param array<string,mixed> $input
     *
     * @return User
     */
    public function create(array $input): User
    {
        $rules = $this->formRequest->rules();

        $attributes = Validator::make($input, $rules)
            ->validated();

        $user = new User();

        $user
            ->forceFill($attributes)
            ->save();

        return $user;
    }

    #endregion
}
