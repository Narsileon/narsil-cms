<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Interfaces\Forms\IResetPasswordForm;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ResetPasswordController
{
    #region CONSTRUCTOR

    /**
     * @param IResetPasswordForm $form
     *
     * @return void
     */
    public function __construct(IResetPasswordForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var IResetPasswordForm
     */
    protected readonly IResetPasswordForm $form;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $form = $this->form->get(
            action: route('password.update'),
            method: MethodEnum::POST,
            submit: trans('ui.reset'),
        );

        return Inertia::render('fortify/form', [
            'data'   => $this->getData(),
            'form'   => $form,
            'labels' => $this->getLabels(),
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,mixed>
     */
    protected function getData(): array
    {
        return [
            'token' => request()->route('token'),
        ];
    }

    /**
     * @return array<string,string>
     */
    protected function getLabels(): array
    {
        return [
            'title' => trans('ui.reset_password'),
        ];
    }

    #endregion
}
