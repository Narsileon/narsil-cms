<?php

namespace Narsil\Http\Resources\DataTable;

#region USE

use Narsil\Constants\TanStackTable;
use Narsil\Enums\Database\TypeNameEnum;
use Narsil\Services\RouteService;
use Narsil\Services\TableService;
use Narsil\Services\TanStackTableService;
use Narsil\Support\Column;
use Narsil\Support\LabelsBag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;
use JsonSerializable;

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
     * @param Model $model
     *
     * @return void
     */
    public function __construct(Builder $query, Model $model)
    {
        $this->model = $model;

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
     * @var Model The model associated to the collection.
     */
    private readonly Model $model;

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
        $with = TanStackTableService::getColumns($this->model->getTable(), $this->model->getHidden());

        $meta = $this->getMeta();

        return array_merge($with, [
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
        $table = $this->model->getTable();

        $id = Str::slug($table);
        $routes = RouteService::getNames($table);
        $title = trans('narsil-cms::ui.' . $table);

        return [
            'id'     => $id,
            'routes' => $routes,
            'title'  => $title,
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
        $search = request(TanStackTable::SEARCH, null);

        if (!$search)
        {
            return;
        }

        $columns = TableService::getColumns($this->model->getTable());

        $columns->each(function (Column $column) use ($query, $search)
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
        $sortings = request(TanStackTable::SORTING, []);

        foreach ($sortings as $key => $value)
        {
            $query->orderBy($key, $value);
        }
    }


    #endregion
}
