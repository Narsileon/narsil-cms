<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\RegisterForm;
use Narsil\Http\Controllers\RenderController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RegisterController extends RenderController
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
        return trans('narsil::ui.registration');
    }

    /**
     * Get the associated form.
     *
     * @return RegisterForm
     */
    protected function getForm(): RegisterForm
    {
        $form = app(RegisterForm::class);

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::ui.registration');
    }

    #endregion
}
