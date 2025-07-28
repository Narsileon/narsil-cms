<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\ConfirmPasswordForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfirmPasswordController extends AbstractController
{
    #region CONSTRUCTOR

    /**
     * @param ConfirmPasswordForm $form
     *
     * @return void
     */
    public function __construct(ConfirmPasswordForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var ConfirmPasswordForm
     */
    protected readonly ConfirmPasswordForm $form;

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
            url: route('password.confirm'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.confirm'),
        );

        return $this->render(
            component: 'narsil/cms::fortify/form',
            title: trans('narsil-cms::ui.confirm_password'),
            description: trans('narsil-cms::ui.confirm_password'),
            props: [
                'form' => $form,
            ]
        );
    }

    #endregion
}
