<?php

namespace App\Http\Resources\DataTable;

#region USE

use App\Services\RouteService;
use App\Services\TanStackTableService;
use App\Support\LabelsBag;
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
     * @param mixed $resource
     * @param Model $model
     *
     * @return void
     */
    public function __construct(Builder $resource, Model $model)
    {
        $this->model = $model;

        $pageIndex = request(self::PAGE, 1);
        $pageSize = request(self::PAGE_SIZE, 10);
        $sortings = request(self::SORTING, []);

        foreach ($sortings as $key => $value)
        {
            $resource->orderBy($key, $value);
        }

        $paginated = $resource->paginate(
            $pageSize,
            ['*'],
            'page',
            $pageIndex,
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
    /**
     * @var string
     */
    public const SORTING = 'sorting';

    #endregion

    #region PROPERTIES

    /**
     * @var Model The model associated to the collection.
     */
    private readonly Model $model;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function toArray(Request $request): JsonSerializable
    {
        return $this->collection->map(function ($item)
        {
            return $item->toArray();
        });
    }

    /**
     * {@inheritdoc}
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
        $routes = RouteService::getRouteNames($table);
        $title = trans('ui.' . $table);

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
            ->add('accessibility.first_page')
            ->add('accessibility.last_page')
            ->add('accessibility.more_pages')
            ->add('accessibility.move_column')
            ->add('accessibility.next_page')
            ->add('accessibility.previous_page')
            ->add('accessibility.sort_column')
            ->add('accessibility.toggle_table_settings')
            ->add('pagination.empty')
            ->add('pagination.pagination')
            ->add('table.columns')
            ->add('ui.create')
            ->add('pagination.results', [
                'from'  => $from,
                'to'    => $to,
                'total' => $total,
            ]);
    }

    #endregion
}
