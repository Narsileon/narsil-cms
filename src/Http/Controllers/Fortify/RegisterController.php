<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\RegisterForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Narsil;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RegisterController
{
    #region CONSTRUCTOR

    /**
     * @param RegisterForm $form
     *
     * @return void
     */
    public function __construct(RegisterForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var RegisterForm
     */
    protected readonly RegisterForm $form;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->form->get(
            url: route('register'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.register'),
        );

        return Narsil::render(
            component: 'narsil/cms::fortify/form',
            title: trans('narsil-cms::ui.registration'),
            description: trans('narsil-cms::ui.registration'),
            props: [
                'form' => $form,
            ]
        );
    }

    #endregion
}
