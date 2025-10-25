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
use Narsil\Http\Collections\DataTableCollection;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Requests\DuplicateManyRequest;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityBlock;
use Narsil\Models\Entities\EntityBlockField;
use Narsil\Models\Hosts\HostLocaleLanguage;

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

        $template = $this->getTemplate($collection);

        if ($template)
        {
            Entity::setTemplate($template);
        }
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

        $template = Entity::getTemplate();

        $query = Entity::query()
            ->with([
                Entity::RELATION_CREATOR,
                Entity::RELATION_DELETER,
                Entity::RELATION_UPDATER,
            ]);

        $collection = new DataTableCollection($query, $template->{Template::HANDLE})
            ->setRevisionable(true)
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

        $template = Entity::getTemplate();

        $form = app()
            ->make(EntityForm::class, [
                'template' => $template
            ])
            ->setAction(route('collections.store', [
                'collection' => $collection
            ]))
            ->setLanguageOptions(HostLocaleLanguage::getUniqueLanguages())
            ->setMethod(MethodEnum::POST)
            ->setSubmitLabel(trans('narsil::ui.save'));

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

        $template = Entity::getTemplate();

        $data = $request->all();

        $rules = app(EntityFormRequest::class, [
            'template' => $template,
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

        $template = Entity::getTemplate();

        $form = app()
            ->make(EntityForm::class, [
                'template' => $template,
            ])
            ->setAction(route('collections.update', [
                'id' => $entity->{Entity::ID},
                'collection' => $collection,
            ]))
            ->setData($entity->toArrayWithTranslations())
            ->setId($entity->{Entity::UUID})
            ->setLanguageOptions(HostLocaleLanguage::getUniqueLanguages())
            ->setMethod(MethodEnum::PATCH)
            ->setSubmitLabel(trans('narsil::ui.update'));

        $title = $form->getTitle();

        $form->setTitle("$title: $id");

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
     * @return ?Template
     */
    protected function getTemplate(int|string $collection): ?Template
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
                EntityBlock::PARENT_UUID => $parent?->{EntityBlock::UUID},
                EntityBlock::POSITION => $key,
            ]);

            $elements = Arr::get($block, EntityBlock::RELATION_BLOCK . '.' . Block::RELATION_ELEMENTS, []);

            foreach ($elements as $key => $element)
            {
                EntityBlockField::create([
                    EntityBlockField::BLOCK_UUID => $entityBlock->{EntityBlock::UUID},
                    EntityBlockField::FIELD_ID => Arr::get($element, BlockElement::ELEMENT_ID),
                    EntityBlockField::VALUE => Arr::get($block, EntityBlock::RELATION_FIELDS . '.' . $key . '.' . EntityBlockField::VALUE),
                ]);
            }

            if ($children = Arr::get($block, EntityBlock::RELATION_CHILDREN))
            {
                $this->syncBlocks($entity, $children, $entityBlock);
            }
        }
    }

    #endregion
}
