<?php

namespace Narsil\Http\Controllers;

#region USE

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Response;
use Narsil\Contracts\FormRequests\EntityFormRequest;
use Narsil\Contracts\Forms\EntityForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Requests\DuplicateManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityBlock;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class EntityController extends AbstractController
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $collection = request()->route('collection');

        if (is_numeric($collection))
        {
            $collection = $this->getTemplate($collection)->{Template::HANDLE};
        }

        Entity::setTableName($collection);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param integer|string $collection
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request, int|string $collection): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Entity::class);

        $template = $this->getTemplate($collection);

        $query = Entity::query()
            ->with([
                Entity::RELATION_CREATOR,
                Entity::RELATION_DELETER,
                Entity::RELATION_UPDATER,
            ]);

        $collection = new DataTableCollection($query, $template->{Template::HANDLE})
            ->toResponse($request)
            ->getData(true);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: $template->{Template::NAME},
            description: $template->{Template::NAME},
            props: [
                'collection' => $collection,
            ]
        );
    }

    /**
     * @param Request $request
     * @param integer|string $collection
     *
     * @return JsonResponse|Response
     */
    public function create(Request $request, int|string $collection): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, Entity::class);

        $template = $this->getTemplate($collection);

        $form = app()->make(EntityForm::class, [
            'template' => $template
        ]);

        $form->action = route('collections.store', [
            'collection' => $collection
        ]);
        $form->method = MethodEnum::POST;
        $form->submitLabel = trans('narsil::ui.save');

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    /**
     * @param Request $request
     * @param integer|string $collection
     *
     * @return RedirectResponse
     */
    public function store(Request $request, int|string $collection): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Entity::class);

        $data = $request->all();

        $rules = app(EntityFormRequest::class, [
            'template' => $this->getTemplate($collection),
        ])->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $entity = Entity::create($attributes);

        if ($blocks = Arr::get($data, Entity::RELATION_BLOCKS))
        {
            $this->syncBlocks($entity, $blocks);
        }

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection,
            ]), $entity)
            ->with('success', trans('narsil::toasts.success.entities.created'));
    }

    /**
     * @param Request $request
     * @param integer|string $collection
     * @param integer $id
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, int|string $collection, int $id): JsonResponse|Response
    {
        if ($revision = $request->query('revision'))
        {
            $entity = Entity::withTrashed()
                ->firstWhere([
                    Entity::UUID => $revision
                ]);
        }
        else
        {
            $entity = Entity::query()
                ->firstWhere([
                    Entity::ID => $id
                ]);
        }

        $revisions = Entity::revisionOptions($id)->get();

        $this->authorize(PermissionEnum::UPDATE, $entity);

        $template = $this->getTemplate($collection);

        $form = app()->make(EntityForm::class, [
            'template' => $template,
        ]);

        $form->action = route('collections.update', [
            'id' => $entity->{Entity::ID},
            'collection' => $collection,
        ]);
        $form->data = $entity;
        $form->id = $entity->{Entity::UUID};
        $form->method = MethodEnum::PATCH;
        $form->submitLabel = trans('narsil::ui.update');
        $form->title = "$form->title: $id";

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: array_merge($form->jsonSerialize(), [
                'revisions' => $revisions,
            ]),
        );
    }

    /**
     * @param Request $request
     * @param integer|string $collection
     * @param integer $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, int|string $collection, int $id): RedirectResponse
    {
        $entity = Entity::query()
            ->firstWhere([
                Entity::ID => $id
            ]);

        $this->authorize(PermissionEnum::UPDATE, $entity);

        if (!$request->get('_dirty'))
        {
            return $this
                ->redirect(route('collections.index', [
                    'collection' => $collection
                ]));
        }

        $data = $request->all();

        $rules = app(EntityFormRequest::class, [
            'template' => $this->getTemplate($collection),
        ])->rules($entity);

        $attributes = Validator::make($data, $rules)
            ->validated();

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
            $this->syncBlocks($replicated, $blocks);
        }

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection
            ]), $entity)
            ->with('success', trans('narsil::toasts.success.entities.updated'));
    }

    /**
     * @param Request $request
     * @param integer|string $collection
     * @param integer $id
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, int|string $collection, int $id): RedirectResponse
    {
        $entity = Entity::query()
            ->firstWhere([
                Entity::ID => $id
            ]);

        $this->authorize(PermissionEnum::DELETE, $entity);

        $entity->forceDelete();

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection,
            ]))
            ->with('success', trans('narsil::toasts.success.entities.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     * @param integer|string $collection
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request, int|string $collection): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Entity::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Entity::query()
            ->whereIn(Entity::ID, $ids)
            ->forceDelete();

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection,
            ]))
            ->with('success', trans('narsil::toasts.success.entities.deleted_many'));
    }

    /**
     * @param Request $request
     * @param integer|string $collection
     * @param integer $id
     *
     * @return RedirectResponse
     */
    public function replicate(Request $request, int|string $collection, int $id): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Entity::class);

        $entity = Entity::query()
            ->firstWhere([
                Entity::ID => $id
            ]);

        $this->replicateEntity($entity);

        return back()
            ->with('success', trans('narsil::toasts.success.entities.replicated'));
    }

    /**
     * @param DuplicateManyRequest $request
     * @param integer|string $collection
     *
     * @return RedirectResponse
     */
    public function replicateMany(DuplicateManyRequest $request, int|string $collection): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Entity::class);

        $ids = $request->validated(DuplicateManyRequest::IDS);

        $entities = Entity::query()
            ->whereIn(Entity::ID, $ids);

        foreach ($entities as $entity)
        {
            $this->replicateEntity($entity);
        }

        return back()
            ->with('success', trans('narsil::toasts.success.entities.replicated_many'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param integer|string $collection
     *
     * @return Template
     */
    protected function getTemplate(int|string $collection): Template
    {
        $query = Template::query()
            ->with([
                Template::RELATION_SECTIONS . '.' . TemplateSection::RELATION_BlOCKS,
                Template::RELATION_SECTIONS . '.' . TemplateSection::RELATION_FIELDS,
            ]);

        if (is_numeric($collection))
        {
            $template = $query
                ->firstWhere(Template::ID, '=', $collection);
        }
        else
        {
            $template = $query
                ->firstWhere(Template::HANDLE, '=', $collection);
        }

        return $template;
    }

    /**
     * @param Entity $entity
     *
     * @return void
     */
    protected function replicateEntity(Entity $entity): void
    {
        $replicated = $entity->replicate();

        $replicated
            ->fill([
                //
            ])
            ->save();
    }

    /**
     * @param Entity $entity
     * @param array $blocks
     * @param EntityBlock|null $parent
     *
     * @return void
     */
    protected function syncBlocks(Entity $entity, array $blocks, ?EntityBlock $parent = null): void
    {
        foreach ($blocks as $key => $block)
        {
            $entityBlock = EntityBlock::create([
                EntityBlock::ENTITY_UUID => $entity->{Entity::UUID},
                EntityBlock::BLOCK_ID => Arr::get($block, EntityBlock::RELATION_BLOCK . '.' . Block::ID),
                EntityBlock::PARENT_ID => $parent?->{EntityBlock::ID},
                EntityBlock::POSITION => $key,
                EntityBlock::VALUES => Arr::get($block, EntityBlock::VALUES, []),
            ]);

            if ($children = Arr::get($block, EntityBlock::RELATION_CHILDREN))
            {
                $this->syncBlocks($entity, $children, $entityBlock);
            }
        }
    }

    #endregion
}
