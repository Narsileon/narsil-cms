<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Narsil\Contracts\Forms\Fortify\TwoFactorChallengeForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Narsil;
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
            submit: trans('narsil-cms::ui.confirm'),
        );

        return Narsil::render('narsil/cms::fortify/form', [
            'form'  => $form,
            'title' => trans('narsil-cms::ui.two_factor_authentication'),
        ]);
    }

    #endregion
}
