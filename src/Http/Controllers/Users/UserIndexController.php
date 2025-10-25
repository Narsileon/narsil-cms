<?php

namespace Narsil\Http\Controllers\Users;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Collections\DataTableCollection;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserIndexController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, User::class);

        $title = trans('narsil::tables.users');
        $description = trans('narsil::tables.users');

        $query = User::query();

        $collection = new DataTableCollection($query, User::TABLE);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: $title,
            description: $description,
            props: [
                'collection' => $collection,
            ]
        );
    }

    #endregion
}
