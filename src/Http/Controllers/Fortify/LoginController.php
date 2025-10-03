<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\LoginForm;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class LoginController extends AbstractController
{
    #region CONSTRUCTOR

    /**
     * @param LoginForm $form
     *
     * @return void
     */
    public function __construct(LoginForm $form)
    {
        $this->form = $form;

        app(TranslationsBag::class)
            ->add('narsil::passwords.link');
    }

    #endregion

    #region PROPERTIES

    /**
     * @var LoginForm
     */
    protected readonly LoginForm $form;

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
