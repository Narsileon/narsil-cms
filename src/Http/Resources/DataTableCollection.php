<?php

namespace Narsil\Http\Resources;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;
use JsonSerializable;
use Narsil\Contracts\Table;
use Narsil\Enums\Database\TypeNameEnum;
use Narsil\Http\Requests\QueryRequest;
use Narsil\Services\TableService;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class DataTableCollection extends ResourceCollection
{
    #region CONSTUCTORS

    /**
     * @param Builder $query
     * @param string $table
     *
     * @return void
     */
    public function __construct(
        Builder $query,
        string $table,
    )
    {
        $template = app()->bound("tables.$table")
            ? app()->make("tables.$table", [
                'table' => $table,
            ])
            : app()->make('tables.entities', [
                'table' => $table,
            ]);

        $this->table = $template;

        $this->search($query);
        $this->sort($query);

        $paginated = $query->paginate(
            perPage: request(self::PAGE_SIZE, 10),
            page: request(self::PAGE, 1),
        );

        parent::__construct($paginated);

        $this->registerLabels();
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string
     */
    public const PAGE = 'page';
    /**
     * @var string
     */
    public const PAGE_SIZE = 'pageSize';

    #endregion

    #region PROPERTIES

    /**
     * @var Table
     */
    protected readonly Table $table;

    /**
     * @var array<string,mixed>
     */
    protected array $options = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): JsonSerializable
    {
        return $this->collection->map(function ($item)
        {
            return $item->toArray();
        });
    }

    /**
     * {@inheritDoc}
     */
    public function with($request): array
    {
        $meta = $this->getMeta();

        return array_merge([
            'columns' => $this->table->getColumns(),
            'columnOrder' => $this->table->getColumnOrder(),
            'columnVisibility' => $this->table->getColumnVisibility(),
            'meta' => $meta,
        ]);
    }

    #endregion

    #region FLUENT METHODS

    /**
     * @param boolean $selectable
     *
     * @return static Returns the current object instance.
     */
    public function setSelectable(bool $selectable): static
    {
        $this->options['selectable'] = $selectable;

        return $this;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,mixed>
     */
    protected function getMeta(): array
    {
        $id = Str::slug($this->table->name);

        return array_merge($this->options, [
            'id'     => $id,
            'routes' => $this->table->getRoutes(),
        ]);
    }

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        $from = $this->resource->firstItem();
        $to = $this->resource->lastItem();
        $total = $this->resource->total();

        app(LabelsBag::class)
            ->add('narsil::accessibility.first_page')
            ->add('narsil::accessibility.last_page')
            ->add('narsil::accessibility.more_pages')
            ->add('narsil::accessibility.move_column')
            ->add('narsil::accessibility.next_page')
            ->add('narsil::accessibility.previous_page')
            ->add('narsil::accessibility.sort_column')
            ->add('narsil::accessibility.toggle_row_menu')
            ->add('narsil::accessibility.toggle_table_settings')
            ->add('narsil::pagination.empty')
            ->add('narsil::pagination.pagination')
            ->add('narsil::placeholders.search')
            ->add('narsil::ui.columns')
            ->add('narsil::ui.create')
            ->add('narsil::ui.delete')
            ->add('narsil::ui.delete_selected')
            ->add('narsil::ui.deselect_all')
            ->add('narsil::ui.edit')
            ->add('narsil::pagination.results', [
                'from'  => $from,
                'to'    => $to,
                'total' => $total,
            ]);
    }


    /**
     * @param Builder $query
     * @param string $search
     *
     * @return void
     */
    protected function search(Builder $query): void
    {
        $search = request(QueryRequest::SEARCH, null);

        if (!$search)
        {
            return;
        }

        $columns = TableService::getColumns($this->table->name);

        $columns->each(function ($column) use ($query, $search)
        {
            switch ($column->type)
            {
                case TypeNameEnum::VARCHAR->value:
                    $query->orWhere($column->name, 'like', '%' . $search . '%');
                    break;
                default:
                    $query;
                    break;
            }
        });
    }

    /**
     * @param string $table
     *
     * @return void
     */
    protected function sort(Builder $query): void
    {
        $sortings = request(QueryRequest::SORTING, []);

        foreach ($sortings as $key => $value)
        {
            $query->orderBy($key, $value);
        }
    }

    #endregion
}
