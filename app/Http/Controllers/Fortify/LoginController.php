<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Interfaces\Forms\ILoginForm;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LoginController
{
    #region CONSTRUCTOR

    /**
     * @param ILoginForm $form
     *
     * @return void
     */
    public function __construct(ILoginForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var ILoginForm
     */
    protected readonly ILoginForm $form;

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
            action: route('login'),
            method: MethodEnum::POST,
            submit: trans('ui.log_in'),
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
            'password_link' => trans('passwords.link'),
            'title'         => trans('ui.connection'),
        ];
    }

    #endregion
}
