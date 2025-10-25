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
class EntityCreateController extends AbstractEntityController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param integer|string $collection
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, int|string $collection): JsonResponse|Response
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

    #endregion
}
