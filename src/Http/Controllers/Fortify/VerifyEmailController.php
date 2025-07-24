<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Narsil\Narsil;
use Narsil\Support\LabelsBag;
use Illuminate\Http\Request;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class VerifyEmailController
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

        return Narsil::render('narsil/cms::fortify/verify-email', [
            'status' => session('status'),
            'title'  => trans('narsil-cms::ui.email_verify'),
        ]);
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
