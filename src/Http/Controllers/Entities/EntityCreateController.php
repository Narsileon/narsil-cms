<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Controllers\Entities;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\RequestMethodEnum;
use Narsil\Base\Http\Controllers\RenderController;
use Narsil\Cms\Contracts\Forms\EntityForm;
use Narsil\Cms\Contracts\Forms\PublishForm;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Traits\IsCollectionController;

#endregion

class EntityCreateController extends RenderController
{
    use IsCollectionController;

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param integer|string $collection
     *
     * @return JsonResponse|View
     */
    public function __invoke(Request $request, int|string $collection): JsonResponse|View
    {
        $this->authorize(AbilityEnum::CREATE, $this->entityClass);

        $form = $this->getForm();

        $publish = app(PublishForm::class);

        return $this->renderBlade('narsil::pages.resources.form', [
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
     * @return BlockForm
     */
    protected function getForm(): EntityForm
    {
        $form = app()
            ->make(EntityForm::class, [
                'template' => $this->template,
            ])
            ->action(route('collections.store', [
                'collection' => $this->template->{Template::TABLE_NAME},
            ]))
            ->defaultLanguage(HostLocaleLanguage::getDefaultLanguage())
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
