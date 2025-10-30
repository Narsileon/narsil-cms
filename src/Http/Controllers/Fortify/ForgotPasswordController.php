<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\ForgotPasswordForm;
use Narsil\Http\Controllers\AbstractController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ForgotPasswordController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $data = $this->getData();
        $form = $this->getForm()
            ->formData($data);

        return $this->render(
            component: 'narsil/cms::fortify/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated data.
     *
     * @return array<string,mixed>
     */
    protected function getData(): array
    {
        $data = [
            'status' => session('status'),
        ];

        return $data;
    }

    /**
     * Get the associated form.
     *
     * @return ForgotPasswordForm
     */
    protected function getForm(): ForgotPasswordForm
    {
        $form = app(ForgotPasswordForm::class);

        return $form;
    }

    #endregion
}
