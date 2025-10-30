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
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->getForm();

        return $this->render(
            component: 'narsil/cms::fortify/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated form.
     *
     * @return ConfirmPasswordForm
     */
    protected function getForm(): ConfirmPasswordForm
    {
        $form = app(ConfirmPasswordForm::class);

        return $form;
    }

    #endregion
}
