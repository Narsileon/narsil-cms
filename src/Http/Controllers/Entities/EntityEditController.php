<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\EntityForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractEntityController;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Hosts\HostLocaleLanguage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityEditController extends AbstractEntityController
{
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

        $revisions = Entity::revisionOptions($id)->get();

        $this->authorize(PermissionEnum::UPDATE, $entity);

        $template = Entity::getTemplate();

        $data = $this->getData($entity);
        $form = $this->getForm($template, $entity)
            ->formData($data);

        $form->title("$form->title: $id");

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: array_merge($form->jsonSerialize(), [
                'revisions' => $revisions,
            ]),
        );
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
            Entity::ATTRIBUTE_HAS_PUBLISHED_REVISION,
        ]);

        $data = $entity->toArrayWithTranslations();

        return $data;
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
     * @param Entity $entity
     *
     * @return BlockForm
     */
    protected function getForm(Template $template, Entity $entity): EntityForm
    {
        $form = app()
            ->make(EntityForm::class, [
                'template' => $template,
            ])
            ->action(route('collections.update', [
                'id' => $entity->{Entity::ID},
                'collection' => $template->{Template::HANDLE},
            ]))
            ->autoSave(true)
            ->id($entity->{Entity::UUID})
            ->languageOptions(HostLocaleLanguage::getUniqueLanguages())
            ->method(MethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    #endregion
}
