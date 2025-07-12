<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Interfaces\Forms\IRegisterForm;
use Inertia\Inertia;
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
     * @return Response
     */
    public function __invoke(): Response
    {
        $form = $this->form::get(
            action: route('register'),
            method: MethodEnum::POST,
            submit: trans('ui.register'),
        );

        $translations = [
            'title' => trans('ui.registration'),
        ];

        return Inertia::render('fortify/form', [
            'form'         => $form,
            'translations' => $translations,
        ]);
    }

    #endregion
}
