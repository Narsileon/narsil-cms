<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Response;
use Narsil\Contracts\Forms\EntityForm;
use Narsil\Contracts\Forms\PublishForm;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Configuration;
use Narsil\Models\Structures\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityData;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Traits\IsCollectionController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityEditController extends RenderController
{
    use IsCollectionController;

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param integer|string $collection
     * @param integer $id
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, int|string $collection, int $id): JsonResponse|Response
    {
        $entity = $this->getEntity($request, $id);

        $revisions = Entity::query()
            ->revisionOptions($id)
            ->get();

        $this->authorize(PermissionEnum::UPDATE, $entity);

        $data = $this->getData($entity);
        $form = $this->getForm($entity);
        $publish = app(PublishForm::class)->layout;

        return $this->render('narsil/cms::resources/form', [
            'data' => $data,
            'form' => $form,
            'publish' => $publish,
            'revisions' => $revisions,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated data.
     *
     * @param Entity $entity
     *
     * @return array<string,mixed>
     */
    protected function getData(Entity $entity): array
    {
        $entity->append([
            Entity::ATTRIBUTE_HAS_DRAFT,
            Entity::ATTRIBUTE_HAS_NEW_REVISION,
            Entity::ATTRIBUTE_HAS_PUBLISHED_REVISION,
        ]);

        foreach ($entity->{Entity::RELATION_DATA}->getAttributes() as $key => $attribute)
        {
            if (in_array($key, [
                EntityData::UUID,
                EntityData::ENTITY_UUID,
            ]))
            {
                continue;
            }

            $entity->setAttribute($key, $attribute);
        }

        $entity->mergeCasts($entity->{Entity::RELATION_DATA}->getCasts());

        $data = $entity->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return Str::ucfirst($this->template->{Template::SINGULAR});
    }

    /**
     * Get the associated entity.
     *
     * @param Request $request
     * @param integer $id
     *
     * @return Entity
     */
    protected function getEntity(Request $request, int $id): Entity
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
                ->with([
                    Entity::RELATION_DRAFT,
                ])
                ->firstWhere([
                    Entity::ID => $id
                ]);

            if ($draft = $entity->{Entity::RELATION_DRAFT})
            {
                $entity = $draft;
            }
        }

        return $entity;
    }

    /**
     * Get the associated form.
     *
     * @param Template $template
     *
     * @return BlockForm
     */
    protected function getForm(Entity $entity): EntityForm
    {
        $configuration = Configuration::firstOrCreate();

        $form = app()
            ->make(EntityForm::class, [
                'template' => $this->template,
            ])
            ->action(route('collections.update', [
                'id' => $entity->{Entity::ID},
                'collection' => $this->template->{Template::HANDLE},
            ]))
            ->autoSave(true)
            ->id($entity->{Entity::UUID})
            ->defaultLanguage($configuration->{Configuration::DEFAULT_LANGUAGE} ?? 'en')
            ->languageOptions(HostLocaleLanguage::getUniqueLanguages())
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return Str::ucfirst($this->template->{Template::SINGULAR});
    }

    #endregion
}
