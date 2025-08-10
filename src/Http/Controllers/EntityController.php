<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Response;
use Narsil\Contracts\FormRequests\EntityFormRequest;
use Narsil\Contracts\Forms\EntityForm;
use Narsil\Contracts\Tables\EntityTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityController extends AbstractController
{
    #region CONSTRUCTOR

    /**
     * @param EntityFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(EntityFormRequest $formRequest)
    {
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var EntityFormRequest
     */
    protected readonly EntityFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $type
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request, string $type): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Entity::class);

        $template = Template::query()
            ->firstWhere(Template::HANDLE, '=', $type);

        $query = Entity::query()
            ->whereRelation(Entity::RELATION_TEMPLATE, Template::HANDLE, '=', $type);

        $dataTable = new DataTableCollection($query, app()->make(EntityTable::class, [
            'type' => $type
        ]));

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: $template->{Template::NAME},
            description: $template->{Template::NAME},
            props: [
                'dataTable' => $dataTable,
            ]
        );
    }

    /**
     * @param Request $request
     * @param string $type
     *
     * @return JsonResponse|Response
     */
    public function create(Request $request, string $type): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, Entity::class);

        $template = Template::query()
            ->firstWhere(Template::HANDLE, '=', $type);

        $form = app()->make(EntityForm::class, [
            'template' => $template
        ]);

        $form->method = MethodEnum::POST;
        $form->url = route('entities.store', [
            'type' => $type
        ]);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    /**
     * @param Request $request
     * @param string $type
     *
     * @return RedirectResponse
     */
    public function store(Request $request, string $type): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Entity::class);

        $data = $request->all();
        $rules = $this->formRequest->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $entity = Entity::create($attributes);

        return $this
            ->redirect(route('entities.index', [
                'type' => $type,
            ]), $entity)
            ->with('success', trans('narsil-cms::toasts.success.entities.created'));
    }

    /**
     * @param Request $request
     * @param integer $id
     * @param string $type
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, int $id, string $type): JsonResponse|Response
    {
        $entity = Entity::ofType($type)
            ->firstWhere([
                Entity::ID => $id
            ]);

        $this->authorize(PermissionEnum::UPDATE, $entity);

        $template = Template::query()
            ->firstWhere(Template::HANDLE, '=', $type);

        $form = app()->make(EntityForm::class, [
            'template' => $template,
        ]);

        $form->method = MethodEnum::PATCH;
        $form->url = route('entities.update', [
            Str::singular(Entity::TABLE) => $entity->{Entity::ID},
            'type' => $type,
        ]);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: array_merge($form->jsonSerialize(), [
                'data' => $entity,
            ]),
        );
    }

    /**
     * @param Request $request
     * @param integer $id
     * @param string $type
     *
     * @return RedirectResponse
     */
    public function update(Request $request, int $id, string $type): RedirectResponse
    {
        $entity = Entity::ofType($type)
            ->firstWhere([
                Entity::ID => $id
            ]);

        $this->authorize(PermissionEnum::UPDATE, $entity);

        $data = $request->all();
        $rules = $this->formRequest->rules($entity);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $entity->update($attributes);

        return $this
            ->redirect(route('entities.index', [
                'type' => $type
            ]), $entity)
            ->with('success', trans('narsil-cms::toasts.success.entities.updated'));
    }

    /**
     * @param Request $request
     * @param integer $id
     * @param string $type
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, int $id, string $type): RedirectResponse
    {
        $entity = Entity::ofType($type)
            ->firstWhere([
                Entity::ID => $id
            ]);

        $this->authorize(PermissionEnum::DELETE, $entity);

        $entity->delete();

        return $this
            ->redirect(route('entities.index', [
                'type' => $type,
            ]))
            ->with('success', trans('narsil-cms::toasts.success.entities.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     * @param string $type
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request, string $type): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Entity::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Entity::ofType($type)
            ->whereIn(Entity::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('entities.index'))
            ->with('success', trans('narsil-cms::toasts.success.entities.deleted_many'));
    }

    #endregion
}
