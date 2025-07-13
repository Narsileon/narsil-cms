<?php

namespace App\Http\Resources;

#region USE

use App\Services\RouteService;
use App\Services\TanStackTableService;
use Illuminate\Database\Eloquent\Builder;
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
     * @param string $table
     *
     * @return void
     */
    public function __construct(Builder $resource, string $table)
    {
        $this->table = $table;

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
     * @var string The name of the table.
     */
    private readonly string $table;

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
        return array_merge(
            TanStackTableService::getColumns($this->table),
            [
                'labels' => $this->getLabels(),
                'meta'   => $this->getMeta(),
            ]
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,string>
     */
    protected function getLabels(): array
    {
        $from = $this->resource->firstItem();
        $to = $this->resource->lastItem();
        $total = $this->resource->total();

        $results = $total === 0 ? trans('pagination.empty') : trans('pagination.results', [
            'from'  => $from,
            'to'    => $to,
            'total' => $total,
        ]);

        return [
            'create'          => trans('ui.create'),
            'columns'         => trans('table.columns'),
            'first_page'      => trans('accessibility.page_first'),
            'last_page'       => trans('accessibility.page_last'),
            'more_pages'      => trans('accessibility.more_pages'),
            'move_column'     => trans('accessibility.column_move'),
            'next_page'       => trans('accessibility.page_next'),
            'pagination'      => trans('pagination.pagination'),
            'previous_page'   => trans('accessibility.page_previous'),
            'results'         => $results,
            'sort_column'     => trans('accessibility.column_sort'),
            'title'           => trans('ui.' . $this->table),
            'toggle_settings' => trans('accessibility.toggle_table_settings'),
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getMeta(): array
    {
        return [
            'id'     => Str::slug($this->table),
            'routes' => RouteService::getRouteNames($this->table),
        ];
    }

    #endregion
}
