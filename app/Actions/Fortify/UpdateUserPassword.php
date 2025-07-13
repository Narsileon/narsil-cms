<?php

namespace App\Actions\Fortify;

#region USE

use App\Interfaces\FormRequests\Fortify\IUpdateUserPasswordFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UpdateUserPassword implements UpdatesUserPasswords
{
    #region CONSTRUCTOR

    /**
     * @param IUpdateUserPasswordFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(IUpdateUserPasswordFormRequest $formRequest)
    {
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var IResetUserPasswordFormRequest
     */
    protected readonly IUpdateUserPasswordFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param User $user
     * @param array<string,string> $input
     *
     * @return void
     */
    public function update(User $user, array $input): void
    {
        $rules = $this->formRequest->rules();

        $attributes = Validator::make($input, $rules)
            ->validated();

        $user
            ->forceFill([
                User::PASSWORD => $attributes[User::PASSWORD],
            ])
            ->save();
    }

    #endregion
}
