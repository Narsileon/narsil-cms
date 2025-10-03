<?php

namespace Narsil\Http\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;
use Narsil\Services\RouteService;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class DataTableFilterCollection extends ResourceCollection
{
    #region CONSTUCTORS

    /**
     * @param mixed $resource
     * @param string $addLabel
     * @param string $labelPath
     * @param ?string $table
     *
     * @return void
     */
    public function __construct(
        mixed $resource,
        string $addLabel,
        string $labelPath = 'label',
        ?string $table = null
    )
    {
        $this->addLabel = $addLabel;
        $this->labelPath = $labelPath;
        $this->table = $table;

        parent::__construct($resource);

        $this->registerLabels();
    }

    #endregion

    #region PROPERTIES

    /**
     * @var string The label of the add button.
     */
    protected readonly string $addLabel;
    /**
     * @var string The name of the label key.
     */
    protected readonly string $labelPath;
    /**
     * @var ?string The name of the table.
     */
    protected readonly ?string $table;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): JsonSerializable
    {
        return $this->collection->map(function ($item)
        {
            return [
                'id'    => $item->id,
                'label' => $item->{$this->labelPath},
            ];
        });
    }

    /**
     * {@inheritDoc}
     */
    public function with($request): array
    {
        return [
            'meta' => $this->getMeta(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,mixed>
     */
    protected function getMeta(): array
    {
        return [
            'addLabel' => $this->addLabel,
            'routes'    => RouteService::getNames($this->table),
            'title'     => trans('narsil::ui.' . $this->table)
        ];
    }

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        app(TranslationsBag::class)
            ->add('narsil::accessibility.toggle_row_menu')
            ->add('narsil::ui.all')
            ->add('narsil::ui.delete')
            ->add('narsil::ui.edit');
    }

    #endregion
}
