<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Response;
use Narsil\Contracts\FormRequests\HostPageFormRequest;
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
class HostPageController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function create(Request $request): JsonResponse|Response
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

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, HostPage::class);

        $data = $request->all();

        $rules = app(HostPageFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        HostPage::create($attributes);

        return back()
            ->with('success', trans('narsil::toasts.success.host_pages.created'));
    }

    /**
     * @param Request $request
     * @param HostPage $hostPage
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, HostPage $hostPage): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $hostPage);

        $form = app(HostPageForm::class)
            ->setAction(route('host_pages.update', $hostPage->{HostPage::ID}))
            ->setData($hostPage->toArrayWithTranslations())
            ->setId($hostPage->{HostPage::ID})
            ->setMethod(MethodEnum::PATCH)
            ->setSubmitLabel(trans('narsil::ui.update'));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    /**
     * @param Request $request
     * @param HostPage $hostPage
     *
     * @return RedirectResponse
     */
    public function update(Request $request, HostPage $hostPage): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $hostPage);

        $data = $request->all();

        $rules = app(HostPageFormRequest::class)
            ->rules($hostPage);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $hostPage->update($attributes);

        return back()
            ->with('success', trans('narsil::toasts.success.host_pages.updated'));
    }

    #endregion
}
