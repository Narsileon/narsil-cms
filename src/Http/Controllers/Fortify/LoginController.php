<?php

namespace Narsil\Cms\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Contracts\Forms\Fortify\LoginForm;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Ui\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LoginController extends RenderController
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(TranslationsBag::class)
            ->add('narsil-cms::passwords.link');
    }

    #endregion

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
        return trans('narsil-cms::ui.connection');
    }

    /**
     * Get the associated form.
     *
     * @return LoginForm
     */
    protected function getForm(): LoginForm
    {
        $form = app(LoginForm::class);

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil-cms::ui.connection');
    }

    #endregion
}
