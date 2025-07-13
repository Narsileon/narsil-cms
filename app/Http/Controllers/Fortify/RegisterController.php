<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Interfaces\Forms\Fortify\IRegisterForm;
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
     * @param IRegisterForm $form
     *
     * @return void
     */
    public function __construct(IRegisterForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var IRegisterForm
     */
    protected readonly IRegisterForm $form;

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
