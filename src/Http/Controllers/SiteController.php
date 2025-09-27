<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Inertia\Response;
use Narsil\Contracts\FormRequests\SiteFormRequest;
use Narsil\Contracts\Forms\SiteForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Requests\DuplicateManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteSubdomain;
use Narsil\Models\Sites\SiteSubdomainLanguage;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Site::class);

        $query = Site::query();

        $collection = new DataTableCollection($query, Site::TABLE);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil::tables.sites'),
            description: trans('narsil::tables.sites'),
            props: [
                'collection' => $collection,
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function create(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, Site::class);

        $form = app(SiteForm::class);

        $form->action = route('sites.store');
        $form->method = MethodEnum::POST;
        $form->submitLabel = trans('narsil::ui.save');

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Site::class);

        $data = $request->all();

        $rules = app(SiteFormRequest::class)->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $site = Site::create($attributes);

        $subdomains = Arr::get($attributes, Site::RELATION_SUBDOMAINS, []);

        $this->syncSubdomains($site, $subdomains);

        return $this
            ->redirect(route('sites.index'))
            ->with('success', trans('narsil::toasts.success.sites.created'));
    }

    /**
     * @param Request $request
     * @param Site $site
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Site $site): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $site);

        $form = app(SiteForm::class);

        $form->action = route('sites.update', $site->{Site::ID});
        $form->data = $site;
        $form->id = $site->{Site::ID};
        $form->method = MethodEnum::PATCH;
        $form->submitLabel = trans('narsil::ui.update');

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    /**
     * @param Request $request
     * @param Site $site
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Site $site): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $site);

        $data = $request->all();

        $rules = app(SiteFormRequest::class)->rules($site);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $site->update($attributes);

        $subdomains = Arr::get($attributes, Site::RELATION_SUBDOMAINS, []);

        $this->syncSubdomains($site, $subdomains);

        return $this
            ->redirect(route('sites.index'))
            ->with('success', trans('narsil::toasts.success.sites.updated'));
    }

    /**
     * @param Request $request
     * @param Site $site
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Site $site): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $site);

        $site->delete();

        return $this
            ->redirect(route('sites.index'))
            ->with('success', trans('narsil::toasts.success.sites.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Site::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Site::whereIn(Site::ID, $ids)->delete();

        return $this
            ->redirect(route('sites.index'))
            ->with('success', trans('narsil::toasts.success.sites.deleted_many'));
    }

    /**
     * @param Request $request
     * @param Site $site
     *
     * @return RedirectResponse
     */
    public function replicate(Request $request, Site $site): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Site::class);

        $this->replicateSite($site);

        return back()
            ->with('success', trans('narsil::toasts.success.sites.replicated'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function replicateMany(DuplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Site::class);

        $ids = $request->validated(DuplicateManyRequest::IDS);

        $sites = Site::query()
            ->findMany($ids);

        foreach ($sites as $site)
        {
            $this->replicateSite($site);
        }

        return back()
            ->with('success', trans('narsil::toasts.success.sites.replicated_many'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Site $site
     *
     * @return void
     */
    protected function replicateSite(Site $site): void
    {
        $replicated = $site->replicate();

        $replicated
            ->fill([
                Site::NAME => $site->{Site::NAME} . ' (copy)',
            ])
            ->save();
    }

    /**
     * @param Site $site
     * @param array $subdomains
     *
     * @return void
     */
    protected function syncSubdomains(Site $site, array $subdomains): void
    {
        $processed = [];

        foreach ($subdomains as $position => $subdomain)
        {
            $id = Arr::get($subdomain, SiteSubdomain::ID);

            $siteSubdomain = $site
                ->subdomains()
                ->find($id);

            if ($siteSubdomain)
            {
                $siteSubdomain
                    ->update([
                        SiteSubdomain::POSITION => $position,
                        SiteSubdomain::SUBDOMAIN => Arr::get($subdomain, SiteSubdomain::SUBDOMAIN),
                    ]);
            }
            else
            {
                $siteSubdomain = $site
                    ->subdomains()
                    ->create([
                        SiteSubdomain::POSITION => $position,
                        SiteSubdomain::SUBDOMAIN => Arr::get($subdomain, SiteSubdomain::SUBDOMAIN),
                    ]);
            }

            $processed[] = $siteSubdomain->{SiteSubdomain::ID};

            $this->syncLanguages($siteSubdomain, Arr::get($subdomain, SiteSubdomain::RELATION_LANGUAGES, []));
        }

        $site
            ->subdomains()
            ->whereNotIn(SiteSubdomain::ID, $processed)
            ->delete();
    }

    /**
     * @param SiteSubdomain $subdomain
     * @param array $languages
     *
     * @return void
     */
    protected function syncLanguages(SiteSubdomain $subdomain, array $languages): void
    {
        $processed = [];

        foreach ($languages as $position => $language)
        {
            $id = Arr::get($language, SiteSubdomainLanguage::ID);

            $siteSubdomainLanguage = $subdomain
                ->languages()
                ->find($id);

            if ($siteSubdomainLanguage)
            {
                $siteSubdomainLanguage
                    ->update([
                        SiteSubdomainLanguage::LANGUAGE => Arr::get($language, SiteSubdomainLanguage::LANGUAGE),
                        SiteSubdomainLanguage::POSITION => $position,
                    ]);
            }
            else
            {
                $siteSubdomainLanguage = $subdomain
                    ->languages()
                    ->create([
                        SiteSubdomainLanguage::LANGUAGE => Arr::get($language, SiteSubdomainLanguage::LANGUAGE),
                        SiteSubdomainLanguage::POSITION => $position,
                    ]);
            }

            $processed[] = $siteSubdomainLanguage->{SiteSubdomainLanguage::ID};
        }

        $subdomain
            ->languages()
            ->whereNotIn(SiteSubdomainLanguage::ID, $processed)
            ->delete();
    }

    #endregion
}
