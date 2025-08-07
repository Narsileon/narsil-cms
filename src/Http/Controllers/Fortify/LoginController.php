<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\LoginForm;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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

        app(LabelsBag::class)
            ->add('narsil-cms::passwords.link');
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
