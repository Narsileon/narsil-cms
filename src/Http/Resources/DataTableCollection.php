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
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class DataTableCollection extends ResourceCollection
{
    #region CONSTUCTORS

    /**
     * @param Builder $query
     * @param Table $table
     *
     * @return void
     */
    public function __construct(
        Builder $query,
        Table $table,
    )
    {
        $this->table = $table;

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

    #region PROTECTED METHODS

    /**
     * @return array<string,mixed>
     */
    protected function getMeta(): array
    {
        $id = Str::slug($this->table->name);

        return [
            'id'     => $id,
            'routes' => $this->table->getRoutes(),
        ];
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
            ->add('narsil-cms::accessibility.first_page')
            ->add('narsil-cms::accessibility.last_page')
            ->add('narsil-cms::accessibility.more_pages')
            ->add('narsil-cms::accessibility.move_column')
            ->add('narsil-cms::accessibility.next_page')
            ->add('narsil-cms::accessibility.previous_page')
            ->add('narsil-cms::accessibility.sort_column')
            ->add('narsil-cms::accessibility.toggle_row_menu')
            ->add('narsil-cms::accessibility.toggle_table_settings')
            ->add('narsil-cms::pagination.empty')
            ->add('narsil-cms::pagination.pagination')
            ->add('narsil-cms::table.columns')
            ->add('narsil-cms::ui.create')
            ->add('narsil-cms::ui.delete')
            ->add('narsil-cms::ui.delete_selected')
            ->add('narsil-cms::ui.deselect_all')
            ->add('narsil-cms::ui.edit')
            ->add('narsil-cms::pagination.results', [
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
