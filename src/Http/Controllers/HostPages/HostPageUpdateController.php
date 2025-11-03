<?php

namespace Narsil\Http\Controllers\HostPages;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\HostPageFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Hosts\HostPage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageUpdateController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $site
     * @param HostPage $hostPage
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, string $site, HostPage $hostPage): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $hostPage);

        $data = $request->all();

        $rules = app(HostPageFormRequest::class)
            ->rules($hostPage);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $hostPage->update($attributes);

        return redirect(route('sites.edit', $site))
            ->with('success', trans('narsil::toasts.success.host_pages.updated'));
    }

    #endregion
}
