<?php

namespace Narsil\Cms\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Base\Contracts\Forms\Fortify\TwoFactorChallengeForm;
use Narsil\Cms\Http\Controllers\RenderController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TwoFactorChallengeController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->getForm();

        return $this->render('narsil/cms::fortify/form', [
            'form' => $form,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil-cms::ui.two_factor_authentication');
    }

    /**
     * Get the associated form.
     *
     * @return TwoFactorChallengeForm
     */
    protected function getForm(): TwoFactorChallengeForm
    {
        $form = app(TwoFactorChallengeForm::class);

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil-cms::ui.two_factor_authentication');
    }

    #endregion
}
