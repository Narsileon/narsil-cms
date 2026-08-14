<?php

namespace Narsil\Cms\Http\Resources\LiveEditor;

#region USE

use Illuminate\Http\Request;
use Narsil\Base\Enums\RequestMethodEnum;
use Narsil\Base\Implementations\Resource;
use Narsil\Base\Support\TranslationsBag;
use Narsil\Cms\Contracts\Forms\LiveEditor\EntityNodeInspectorForm;
use Narsil\Cms\Models\Configuration;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Services\LiveEditor\EntityNodeInspectorService;

#endregion

class EntityNodeInspectorResource extends Resource
{
    #region CONSTRUCTOR

    /**
     * @param EntityNode $resource
     * @param Entity $entity
     * @param string $updateUrl
     *
     * @return void
     */
    public function __construct(mixed $resource, Entity $entity, string $updateUrl)
    {
        $this->entity = $entity;
        $this->updateUrl = $updateUrl;

        parent::__construct($resource);
    }

    #endregion

    #region PROPERTIES

    /**
     * The entity the node belongs to.
     *
     * @var Entity
     */
    protected readonly Entity $entity;

    /**
     * The url the inspector form submits to.
     *
     * @var string
     */
    protected readonly string $updateUrl;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        $inspector = app(EntityNodeInspectorService::class)->build($this->entity, $this->resource);

        $configuration = Configuration::firstOrCreate();

        $form = app()
            ->make(EntityNodeInspectorForm::class, [
                'elements' => $inspector['elements'],
            ])
            ->action($this->updateUrl)
            ->autoSave(false)
            ->id($inspector['nodeUuid'])
            ->defaultLanguage($configuration->{Configuration::DEFAULT_LANGUAGE} ?? 'en')
            ->languages(HostLocaleLanguage::getUniqueLanguages())
            ->method(RequestMethodEnum::PATCH->value)
            ->options($inspector['options'])
            ->submitLabel(trans('narsil::ui.save'));

        return [
            'blockId' => $inspector['blockId'],
            'data' => $inspector['data'],
            'form' => $form,
            'label' => $inspector['label'],
            'nodeUuid' => $inspector['nodeUuid'],
            'routes' => [
                'update' => $this->updateUrl,
            ],
            // The inspector is fetched after the page has rendered, so the
            // translations its inputs registered have to travel with it.
            'translations' => app(TranslationsBag::class)->get(),
        ];
    }

    #endregion
}
