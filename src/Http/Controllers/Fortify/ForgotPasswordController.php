<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\ForgotPasswordForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ForgotPasswordController extends AbstractController
{
    #region CONSTRUCTOR

    /**
     * @param ForgotPasswordForm $form
     *
     * @return void
     */
    public function __construct(ForgotPasswordForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var ForgotPasswordForm
     */
    protected readonly ForgotPasswordForm $form;

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
            url: route('password.email'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.send'),
        );

        return $this->render(
            component: 'narsil/cms::fortify/form',
            title: trans('narsil-cms::ui.reset_password'),
            description: trans('narsil-cms::ui.reset_password'),
            props: [
                'form' => $form,
                'status' => session('status'),
            ]
        );
    }

    #endregion
}
