<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Narsil\Contracts\Forms\Fortify\RegisterForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Narsil;
use Illuminate\Http\Request;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RegisterController
{
    #region CONSTRUCTOR

    /**
     * @param RegisterForm $form
     *
     * @return void
     */
    public function __construct(RegisterForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var RegisterForm
     */
    protected readonly RegisterForm $form;

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
            action: route('register'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.register'),
        );

        return Narsil::render('narsil/cms::fortify/form', [
            'form'  => $form,
            'title' => trans('narsil-cms::ui.registration'),
        ]);
    }

    #endregion
}
