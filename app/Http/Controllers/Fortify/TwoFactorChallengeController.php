<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Services\FormService;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TwoFactorChallengeController
{
    #region PUBLIC METHODS

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $form = (FormService::getForm('confirm-password'))::get(
            action: route('two-factor.login'),
            method: MethodEnum::POST,
            submit: trans('ui.confirm'),
        );

        $translations = [
            'title' => trans('ui.two_factor_authentication'),
        ];

        return Inertia::render('fortify/two-factor-challenge', [
            'form'         => $form,
            'translations' => $translations,
        ]);
    }

    #endregion
}
