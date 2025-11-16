<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Response;
use Narsil\Contracts\Forms\EntityForm;
use Narsil\Contracts\Forms\PublishForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Traits\IsCollectionController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityCreateController extends RenderController
{
    use IsCollectionController;

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

        $form = $this->getForm($template);
        $publish = app(PublishForm::class)->layout;

        return $this->render('narsil/cms::resources/form', [
            'form' => $form,
            'publish' => $publish,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        $template = Entity::getTemplate();

        return Str::singular($template->{Template::NAME});
    }

    /**
     * Get the associated form.
     *
     * @param Template $template
     *
     * @return BlockForm
     */
    protected function getForm(Template $template): EntityForm
    {
        $form = app()
            ->make(EntityForm::class, [
                'template' => $template
            ])
            ->action(route('collections.store', [
                'collection' => $template->{Template::HANDLE}
            ]))
            ->languageOptions(HostLocaleLanguage::getUniqueLanguages())
            ->method(MethodEnum::POST->value)
            ->submitLabel(trans('narsil::ui.save'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        $template = Entity::getTemplate();

        return Str::singular($template->{Template::NAME});
    }

    #endregion
}
