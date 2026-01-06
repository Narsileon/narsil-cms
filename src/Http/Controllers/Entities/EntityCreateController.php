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
        $this->authorize(PermissionEnum::CREATE, $this->entityClass);

        $form = $this->getForm();

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
        return Str::ucfirst($this->template->{Template::SINGULAR});
    }

    /**
     * Get the associated form.
     *
     * @return BlockForm
     */
    protected function getForm(): EntityForm
    {
        $configuration = Configuration::firstOrCreate();

        $form = app()
            ->make(EntityForm::class, [
                'template' => $this->template
            ])
            ->action(route('collections.store', [
                'collection' => $this->template->{Template::TABLE_NAME}
            ]))
            ->defaultLanguage($configuration->{Configuration::DEFAULT_LANGUAGE} ?? 'en')
            ->languageOptions(HostLocaleLanguage::getUniqueLanguages())
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil::ui.save'));

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
