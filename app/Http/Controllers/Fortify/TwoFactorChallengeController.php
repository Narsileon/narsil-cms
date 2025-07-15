<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Contracts\Forms\Fortify\TwoFactorChallengeForm;
use App\Enums\Forms\MethodEnum;
use App\Narsil;
use Illuminate\Http\Request;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TwoFactorChallengeController
{
    #region CONSTRUCTOR

    /**
     * @param TwoFactorChallengeForm $form
     *
     * @return void
     */
    public function __construct(TwoFactorChallengeForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var TwoFactorChallengeForm
     */
    protected readonly TwoFactorChallengeForm $form;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->form->get(
            action: route('two-factor.login'),
            method: MethodEnum::POST,
            submit: trans('ui.confirm'),
        );

        return Narsil::render('fortify/form', [
            'form'  => $form,
            'title' => trans('ui.two_factor_authentication'),
        ]);
    }

    #endregion
}
