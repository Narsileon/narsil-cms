<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Interfaces\Forms\IForgotPasswordForm;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ForgotPasswordController
{
    #region CONSTRUCTOR

    /**
     * @param IForgotPasswordForm $form
     *
     * @return void
     */
    public function __construct(IForgotPasswordForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var IForgotPasswordForm
     */
    protected readonly IForgotPasswordForm $form;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $form = $this->form->get(
            action: route('password.email'),
            method: MethodEnum::POST,
            submit: trans('ui.send'),
        );

        $status = session('status');

        return Inertia::render('fortify/form', [
            'form'   => $form,
            'labels' => $this->getLabels(),
            'status' => $status,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,string>
     */
    protected function getLabels(): array
    {
        return [
            'back'          => trans('ui.back'),
            'password_link' => trans('passwords.link'),
            'title'         => trans('ui.reset_password'),
        ];
    }

    #endregion
}
