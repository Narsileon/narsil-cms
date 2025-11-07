<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class VerifyEmailController extends AbstractController
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(TranslationsBag::class)
            ->add('narsil::ui.send_again')
            ->add('narsil::verify-email.instruction')
            ->add('narsil::verify-email.prompt')
            ->add('narsil::verify-email.sent');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $title = trans('narsil::ui.email_verify');
        $description = trans('narsil::ui.email_verify');

        $data = $this->getData();

        return $this->render(
            component: 'narsil/cms::fortify/verify-email',
            title: $title,
            description: $description,
            props: $data,
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

    #endregion
}
