<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Interfaces\Forms\ITwoFactorChallengeForm;
use Inertia\Inertia;
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
     * @param ITwoFactorChallengeForm $form
     *
     * @return void
     */
    public function __construct(ITwoFactorChallengeForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var ITwoFactorChallengeForm
     */
    protected readonly ITwoFactorChallengeForm $form;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $form = $this->form->get(
            action: route('two-factor.login'),
            method: MethodEnum::POST,
            submit: trans('ui.confirm'),
        );

        return Inertia::render('fortify/form', [
            'form'   => $form,
            'labels' => $this->getLabels(),
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,string>
     */
    protected function getLabels(): array
    {
        return [
            'title' => trans('ui.two_factor_authentication'),
        ];
    }

    #endregion
}
