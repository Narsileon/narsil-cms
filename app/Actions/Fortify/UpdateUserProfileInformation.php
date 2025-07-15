<?php

namespace App\Actions\Fortify;

#region USE

use App\Contracts\FormRequests\Fortify\UpdateUserProfileInformationFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    #region CONSTRUCTOR

    /**
     * @param UpdateUserProfileInformationFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(UpdateUserProfileInformationFormRequest $formRequest)
    {
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var UpdateUserProfileInformationFormRequest
     */
    protected readonly UpdateUserProfileInformationFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param User $user
     * @param array<string,mixed> $input
     *
     * @return void
     */
    public function update(User $user, array $input): void
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
