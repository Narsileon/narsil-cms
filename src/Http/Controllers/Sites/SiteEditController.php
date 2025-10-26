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
     * @param Request $request
     *
     * @return array<string,mixed>
     */
    protected function getData(Host $host): array
    {
        $data = new SiteResource($host)->resolve();

        return $data;
    }

    /**
     * Get the associated form.
     *
     * @param Host $host
     *
     * @return SiteForm
     */
    protected function getForm(Host $host): SiteForm
    {
        $form = app()
            ->make(SiteForm::class)
            ->setAction(route('sites.update', $host->{Host::HANDLE}))
            ->setId($host->{Host::ID})
            ->setMethod(MethodEnum::PATCH)
            ->setLanguageOptions([])
            ->setSubmitLabel(trans('narsil::ui.update'));

        return $form;
    }

    #endregion
}
