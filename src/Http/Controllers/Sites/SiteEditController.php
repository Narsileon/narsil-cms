<?php

namespace Narsil\Http\Controllers\Sites;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\SiteForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Resources\SiteResource;
use Narsil\Models\Hosts\Host;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteEditController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $site
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, string $site): JsonResponse|Response
    {
        $host = Host::query()
            ->with([
                Host::RELATION_PAGES,
            ])
            ->where(Host::HANDLE, $site)
            ->first();

        if (!$host)
        {
            abort(404);
        }

        $this->authorize(PermissionEnum::UPDATE, $host);

        $form = app(SiteForm::class)
            ->setAction(route('sites.update', $site))
            ->setData(new SiteResource($host)->toArray($request))
            ->setId($host->{Host::ID})
            ->setMethod(MethodEnum::PATCH)
            ->setLanguageOptions([])
            ->setSubmitLabel(trans('narsil::ui.update'));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion
}
