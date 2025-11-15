<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\ForgotPasswordForm;
use Narsil\Http\Controllers\RenderController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ForgotPasswordController extends RenderController
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
            'status' => session('status'),
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil::ui.reset_password');
    }

    /**
     * Get the associated form.
     *
     * @return ForgotPasswordForm
     */
    protected function getForm(): ForgotPasswordForm
    {
        $form = app(ForgotPasswordForm::class);

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::ui.reset_password');
    }

    #endregion
}
