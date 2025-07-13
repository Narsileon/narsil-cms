<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Narsil;
use App\Support\LabelsBag;
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

        return Narsil::render('fortify/verify-email', [
            'status' => session('status'),
            'title'  => trans('ui.email_verify'),
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
            ->add('verify-email.instruction')
            ->add('verify-email.prompt')
            ->add('verify-email.send_again')
            ->add('verify-email.sent');
    }

    #endregion
}
