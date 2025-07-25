<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\TwoFactorChallengeForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Narsil;

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
            url: route('two-factor.login'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.confirm'),
        );

        return Narsil::render(
            component: 'narsil/cms::fortify/form',
            title: trans('narsil-cms::ui.two_factor_authentication'),
            description: trans('narsil-cms::ui.two_factor_authentication'),
            props: [
                'form' => $form,
            ]
        );
    }

    #endregion
}
