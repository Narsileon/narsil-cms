<?php

namespace App\Http\Resources\DataTable;

#region USE

use App\Services\RouteService;
use App\Support\LabelsBag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class DataTableFilterCollection extends ResourceCollection
{
    #region CONSTUCTORS

    /**
     * @param mixed $resource
     * @param string $addLabel
     * @param string $labelKey
     * @param ?string $table
     *
     * @return void
     */
    public function __construct(
        mixed $resource,
        string $addLabel,
        string $labelKey = 'label',
        ?string $table = null
    )
    {
        $this->addLabel = $addLabel;
        $this->labelKey = $labelKey;
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
    protected readonly string $labelKey;
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
                'label' => $item->{$this->labelKey},
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
            'title'     => trans('ui.' . $this->table)
        ];
    }

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        app(LabelsBag::class)
            ->add('accessibility.toggle_row_menu')
            ->add('ui.all')
            ->add('ui.delete')
            ->add('ui.edit');
    }

    #endregion
}
