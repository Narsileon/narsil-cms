<?php

namespace Narsil\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\HostForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Hosts\Host;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostCreateController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, Host::class);

        $form = $this->getForm();

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated form.
     *
     * @return HostForm
     */
    protected function getForm(): HostForm
    {
        $form = app()
            ->make(HostForm::class)
            ->setAction(route('hosts.store'))
            ->setMethod(MethodEnum::POST)
            ->setSubmitLabel(trans('narsil::ui.save'));

        return $form;
    }

    #endregion
}
