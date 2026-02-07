<?php

namespace Narsil\Cms\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Contracts\Forms\Fortify\ResetPasswordForm;
use Narsil\Cms\Http\Controllers\RenderController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ResetPasswordController extends RenderController
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
        $token = $request->route('token');

        return $this->render('narsil/cms::fortify/form', [
            'form' => $form,
            'token' => $token,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil-cms::ui.reset_password');
    }

    /**
     * Get the associated form.
     *
     * @return ResetPasswordForm
     */
    protected function getForm(): ResetPasswordForm
    {
        $form = app(ResetPasswordForm::class);

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil-cms::ui.reset_password');
    }

    #endregion
}
