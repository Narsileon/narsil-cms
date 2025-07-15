<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Contracts\Forms\Fortify\RegisterForm;
use App\Enums\Forms\MethodEnum;
use App\Narsil;
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
            submit: trans('ui.register'),
        );

        return Narsil::render('fortify/form', [
            'form'  => $form,
            'title' => trans('ui.registration'),
        ]);
    }

    #endregion
}
