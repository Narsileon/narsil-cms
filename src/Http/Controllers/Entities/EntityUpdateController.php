<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\EntityFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Entities\Entity;
use Narsil\Services\EntityService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityUpdateController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param integer|string $collection
     * @param integer $id
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, int|string $collection, int $id): RedirectResponse
    {
        $entity = Entity::query()
            ->firstWhere([
                Entity::ID => $id
            ]);

        $this->authorize(PermissionEnum::UPDATE, $entity);

        $template = Entity::getTemplate();

        if (!$request->get('_dirty'))
        {
            return $this
                ->redirect(route('collections.index', [
                    'collection' => $collection
                ]));
        }

        $data = $request->all();

        $rules = app(EntityFormRequest::class, [
            'template' => $template,
        ])->rules($entity);

        $attributes = Validator::make($data, $rules)
            ->validated();

        if ($request->get('_autosave'))
        {
            $entity->fill(array_merge($attributes, [
                Entity::UPDATED_AT => Carbon::now(),
                Entity::UPDATED_BY => Auth::id(),
            ]));

            $entity->save();

            if ($blocks = Arr::get($data, Entity::RELATION_BLOCKS))
            {
                EntityService::syncBlocks($entity, $blocks);
            }

            return back();
        }
        else
        {
            $replicated = $entity->replicate();

            $replicated->fill(array_merge($attributes, [
                Entity::CREATED_AT => $entity->{Entity::CREATED_AT},
                Entity::CREATED_BY => $entity->{Entity::CREATED_BY},
                Entity::UPDATED_AT => Carbon::now(),
                Entity::UPDATED_BY => Auth::id(),
            ]));

            $replicated->save();


            $entity->discardChanges();
            $entity->delete();

            $replicated->pruneRevisions(2);

            if ($blocks = Arr::get($data, Entity::RELATION_BLOCKS))
            {
                EntityService::syncBlocks($replicated, $blocks);
            }

            return $this
                ->redirect(route('collections.index', [
                    'collection' => $collection
                ]), $entity)
                ->with('success', trans('narsil::toasts.success.entities.updated'));
        }
    }

    #endregion
}
