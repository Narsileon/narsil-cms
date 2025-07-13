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
        $form = $this->form->get(
            action: route('password.confirm'),
            method: MethodEnum::POST,
            submit: trans('ui.confirm'),
        );

        return Inertia::render('fortify/form', [
            'form'   => $form,
            'labels' => $this->getLabels(),
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
            'title' => trans('ui.confirm_password'),
        ];
    }

    #endregion
}
