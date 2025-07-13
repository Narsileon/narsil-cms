<?php

namespace App\Actions\Fortify;

#region USE

use App\Interfaces\FormRequests\Fortify\IUpdateUserProfileInformationFormRequest;
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
     * @param IUpdateUserProfileInformationFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(IUpdateUserProfileInformationFormRequest $formRequest)
    {
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var IUpdateUserProfileInformationFormRequest
     */
    protected readonly IUpdateUserProfileInformationFormRequest $formRequest;

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
