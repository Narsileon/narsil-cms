<?php

namespace App\Http\Controllers\Fortify;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Interfaces\Forms\Fortify\ILoginForm;
use App\Narsil;
use App\Support\LabelsBag;
use Illuminate\Http\Request;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LoginController
{
    #region CONSTRUCTOR

    /**
     * @param ILoginForm $form
     *
     * @return void
     */
    public function __construct(ILoginForm $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var ILoginForm
     */
    protected readonly ILoginForm $form;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $this->registerLabels();

        $form = $this->form->get(
            action: route('login'),
            method: MethodEnum::POST,
            submit: trans('ui.log_in'),
        );

        return Narsil::render('fortify/form', [
            'form'   => $form,
            'status' => session('status'),
            'title'  => trans('ui.connection'),
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
            ->add('passwords.link');
    }

    #endregion
}
