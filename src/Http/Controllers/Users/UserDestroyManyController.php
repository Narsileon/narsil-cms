<?php

namespace Narsil\Cms\Http\Controllers\Users;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\DestroyManyRequest;
use Narsil\Cms\Models\User;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, User::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        User::query()
            ->whereIn(User::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('users.index'))
            ->with('success', ModelService::getSuccessMessage(User::TABLE, ModelEventEnum::DELETED_MANY));
    }

    #endregion
}
