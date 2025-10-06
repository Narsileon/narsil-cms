<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Inertia\Response;
use Narsil\Contracts\FormRequests\HostFormRequest;
use Narsil\Contracts\Forms\HostForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Requests\DuplicateManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class HostController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Host::class);

        $query = Host::query()
            ->withCount(Host::RELATION_LOCALES);

        $collection = new DataTableCollection($query, Host::TABLE);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil::tables.hosts'),
            description: trans('narsil::tables.hosts'),
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
        $this->authorize(PermissionEnum::CREATE, Host::class);

        $form = app(HostForm::class);

        $form->action = route('hosts.store');
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
        $this->authorize(PermissionEnum::CREATE, Host::class);

        $data = $request->all();

        $rules = app(HostFormRequest::class)->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $host = Host::create($attributes);

        $locales = Arr::get($attributes, Host::RELATION_LOCALES, []);

        $this->syncLocales($host, $locales);

        return $this
            ->redirect(route('hosts.index'))
            ->with('success', trans('narsil::toasts.success.hosts.created'));
    }

    /**
     * @param Request $request
     * @param Host $host
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Host $host): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $host);

        $form = app(HostForm::class);

        $form->action = route('hosts.update', $host->{Host::ID});
        $form->data = $host;
        $form->id = $host->{Host::ID};
        $form->method = MethodEnum::PATCH;
        $form->submitLabel = trans('narsil::ui.update');

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    /**
     * @param Request $request
     * @param Host $host
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Host $host): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $host);

        $data = $request->all();

        $rules = app(HostFormRequest::class)->rules($host);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $host->update($attributes);

        $locales = Arr::get($attributes, Host::RELATION_LOCALES, []);

        $this->syncLocales($host, $locales);

        return $this
            ->redirect(route('hosts.index'))
            ->with('success', trans('narsil::toasts.success.hosts.updated'));
    }

    /**
     * @param Request $request
     * @param Host $host
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Host $host): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $host);

        $host->delete();

        return $this
            ->redirect(route('hosts.index'))
            ->with('success', trans('narsil::toasts.success.hosts.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Host::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Host::whereIn(Host::ID, $ids)->delete();

        return $this
            ->redirect(route('hosts.index'))
            ->with('success', trans('narsil::toasts.success.hosts.deleted_many'));
    }

    /**
     * @param Request $request
     * @param Host $host
     *
     * @return RedirectResponse
     */
    public function replicate(Request $request, Host $host): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Host::class);

        $this->replicateHost($host);

        return back()
            ->with('success', trans('narsil::toasts.success.hosts.replicated'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function replicateMany(DuplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Host::class);

        $ids = $request->validated(DuplicateManyRequest::IDS);

        $hosts = Host::query()
            ->findMany($ids);

        foreach ($hosts as $host)
        {
            $this->replicateHost($host);
        }

        return back()
            ->with('success', trans('narsil::toasts.success.hosts.replicated_many'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Host $host
     *
     * @return void
     */
    protected function replicateHost(Host $host): void
    {
        $replicated = $host->replicate();

        $replicated
            ->fill([
                Host::NAME => $host->{Host::NAME} . ' (copy)',
            ])
            ->save();
    }

    /**
     * @param HostLocale $hostLocale
     * @param array $languages
     *
     * @return void
     */
    protected function syncLanguages(HostLocale $hostLocale, array $languages): void
    {
        $processed = [];

        foreach ($languages as $position => $language)
        {
            $id = Arr::get($language, HostLocaleLanguage::ID);

            $hostLocaleLanguage = $hostLocale
                ->languages()
                ->find($id);

            if ($hostLocaleLanguage)
            {
                $hostLocaleLanguage
                    ->update([
                        HostLocaleLanguage::LANGUAGE => Arr::get($language, HostLocaleLanguage::LANGUAGE),
                        HostLocaleLanguage::POSITION => $position,
                    ]);
            }
            else
            {
                $hostLocaleLanguage = $hostLocale
                    ->languages()
                    ->create([
                        HostLocaleLanguage::LANGUAGE => Arr::get($language, HostLocaleLanguage::LANGUAGE),
                        HostLocaleLanguage::POSITION => $position,
                    ]);
            }

            $processed[] = $hostLocaleLanguage->{HostLocaleLanguage::ID};
        }

        $hostLocale
            ->languages()
            ->whereNotIn(HostLocaleLanguage::ID, $processed)
            ->delete();
    }

    /**
     * @param Host $host
     * @param array $locales
     *
     * @return void
     */
    protected function syncLocales(Host $host, array $locales): void
    {
        $processed = [];

        foreach ($locales as $position => $locale)
        {
            $id = Arr::get($locale, HostLocale::ID);

            $hostLocale = $host
                ->locales()
                ->find($id);

            if ($hostLocale)
            {
                $hostLocale
                    ->update([
                        HostLocale::COUNTRY => Arr::get($locale, HostLocale::COUNTRY),
                        HostLocale::PATTERN => Arr::get($locale, HostLocale::PATTERN),
                        HostLocale::POSITION => $position,
                    ]);
            }
            else
            {
                $hostLocale = $host
                    ->locales()
                    ->create([
                        HostLocale::COUNTRY => Arr::get($locale, HostLocale::COUNTRY),
                        HostLocale::PATTERN => Arr::get($locale, HostLocale::PATTERN),
                        HostLocale::POSITION => $position,
                    ]);
            }

            $processed[] = $hostLocale->{HostLocale::ID};

            $this->syncLanguages($hostLocale, Arr::get($locale, HostLocale::RELATION_LANGUAGES, []));
        }

        $host
            ->locales()
            ->whereNotIn(HostLocale::ID, $processed)
            ->delete();
    }

    #endregion
}
