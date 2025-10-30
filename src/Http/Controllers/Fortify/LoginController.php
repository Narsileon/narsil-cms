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
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LoginController extends AbstractController
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(TranslationsBag::class)
            ->add('narsil::passwords.link');
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
        $data = $this->getData();
        $form = $this->getForm()
            ->setData($data);

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
     * @return LoginForm
     */
    protected function getForm(): LoginForm
    {
        $form = app(LoginForm::class);

        return $form;
    }

    #endregion
}
