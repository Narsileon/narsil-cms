<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\ConfirmPasswordForm;
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
        return $this->render(
            component: 'narsil/cms::fortify/form',
            props: $this->form->jsonSerialize(),
        );
    }

    #endregion
}
