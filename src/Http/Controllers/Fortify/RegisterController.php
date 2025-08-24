<?php

namespace Narsil\Http\Controllers\Fortify;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\RegisterForm;
use Narsil\Http\Controllers\AbstractController;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class RegisterController extends AbstractController
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
        return $this->render(
            component: 'narsil/cms::fortify/form',
            props: $this->form->jsonSerialize(),
        );
    }

    #endregion
}
