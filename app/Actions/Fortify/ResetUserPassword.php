<?php

namespace App\Actions\Fortify;

#region USE

use App\Contracts\FormRequests\Fortify\ResetUserPasswordFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ResetUserPassword implements ResetsUserPasswords
{
    #region CONSTRUCTOR

    /**
     * @param ResetUserPasswordFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(ResetUserPasswordFormRequest $formRequest)
    {
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var ResetUserPasswordFormRequest
     */
    protected readonly ResetUserPasswordFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param User $user
     * @param array<string,string> $input
     *
     * @return void
     */
    public function reset(User $user, array $input): void
    {
        $rules = $this->formRequest->rules();

        $attributes = Validator::make($input, $rules)
            ->validated();

        $user
            ->forceFill($attributes)
            ->save();
    }

    #endregion
}
