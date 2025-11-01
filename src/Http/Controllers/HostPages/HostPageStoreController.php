<?php

namespace Narsil\Http\Controllers\HostPages;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\HostPageFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Resources\HostPages\HostPageResource;
use Narsil\Models\Hosts\HostPage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageStoreController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, HostPage::class);

        $data = $request->all();

        $rules = app(HostPageFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $hostPage = HostPage::create($attributes);

        $resource = new HostPageResource($hostPage)->resolve();

        return back()
            ->with('data', $resource)
            ->with('success', trans('narsil::toasts.success.host_pages.created'));
    }

    #endregion
}
