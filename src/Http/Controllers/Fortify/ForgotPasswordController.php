<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\ForgotPasswordForm;
use Narsil\Http\Controllers\AbstractController;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
        return $this->render(
            component: 'narsil/cms::fortify/form',
            props: array_merge($this->form->jsonSerialize(), [
                'status' => session('status'),
            ]),
        );
    }

    #endregion
}
