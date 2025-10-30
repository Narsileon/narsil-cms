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
class HostEditController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Host $host
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Host $host): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $host);

        $data = $this->getData($host);
        $form = $this->getForm($host)
            ->setData($data);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated data.
     *
     * @param Host $host
     *
     * @return array<string,mixed>
     */
    protected function getData(Host $host): array
    {
        $data = $host->toArrayWithTranslations();

        return $data;
    }

    /**
     * Get the associated form.
     *
     * @param Host $host
     *
     * @return HostForm
     */
    protected function getForm(Host $host): HostForm
    {
        $form = app(HostForm::class)
            ->setAction(route('hosts.update', $host->{Host::ID}))
            ->setId($host->{Host::ID})
            ->setMethod(MethodEnum::PATCH)
            ->setSubmitLabel(trans('narsil::ui.update'));

        return $form;
    }

    #endregion
}
