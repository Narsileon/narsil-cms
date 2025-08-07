<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\LoginForm;
use Narsil\Enums\Forms\MethodEnum;
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
        app(LabelsBag::class)
            ->add('narsil-cms::passwords.link');

        $form = $this->form->get(
            url: route('login'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.log_in'),
        );

        return $this->render(
            component: 'narsil/cms::fortify/form',
            title: trans('narsil-cms::ui.connection'),
            description: trans('narsil-cms::ui.connection'),
            props: [
                'form' => $form,
                'status' => session('status'),
            ]
        );
    }

    #endregion
}
