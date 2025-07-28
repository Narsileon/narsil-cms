<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class VerifyEmailController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $this->registerLabels();

        return $this->render(
            component: 'narsil/cms::fortify/verify-email',
            title: trans('narsil-cms::ui.email_verify'),
            description: trans('narsil-cms::ui.email_verify'),
            props: [
                'status' => session('status'),
            ]
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        app(LabelsBag::class)
            ->add('narsil-cms::verify-email.instruction')
            ->add('narsil-cms::verify-email.prompt')
            ->add('narsil-cms::verify-email.send_again')
            ->add('narsil-cms::verify-email.sent');
    }

    #endregion
}
