<?php

namespace Narsil\Http\Controllers\HostPages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\HostPageForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Hosts\HostPage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageCreateController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, HostPage::class);

        $form = app(HostPageForm::class)
            ->setAction(route('host_pages.store'))
            ->setData($request->all())
            ->setMethod(MethodEnum::POST)
            ->setSubmitLabel(trans('narsil::ui.save'));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion
}
