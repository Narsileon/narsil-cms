<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Interfaces\Forms\IConfirmPasswordForm;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfirmPasswordController
{
    #region CONSTRUCTOR

    /**
     * @param IConfirmPasswordForm $form
     *
     * @return void
     */
    public function __construct(IConfirmPasswordForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var IConfirmPasswordForm
     */
    protected readonly IConfirmPasswordForm $form;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $form = $this->form::get(
            action: route('password.confirm'),
            method: MethodEnum::POST,
            submit: trans('ui.confirm'),
        );

        $translations = [
            'title' => trans('ui.confirm_password'),
        ];

        return Inertia::render('fortify/form', [
            'form'         => $form,
            'translations' => $translations,
        ]);
    }

    #endregion
}
