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
class HostPageEditController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param HostPage $hostPage
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, HostPage $hostPage): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $hostPage);

        $form = app(HostPageForm::class)
            ->setAction(route('host-pages.update', $hostPage->{HostPage::ID}))
            ->setData($hostPage->toArrayWithTranslations())
            ->setId($hostPage->{HostPage::ID})
            ->setMethod(MethodEnum::PATCH)
            ->setSubmitLabel(trans('narsil::ui.update'));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion
}
