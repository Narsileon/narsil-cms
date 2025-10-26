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

    #endregion
}
