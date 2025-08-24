<?php

namespace Narsil\Actions\Fortify;

#region USE

use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Narsil\Contracts\FormRequests\Fortify\CreateNewUserFormRequest;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
