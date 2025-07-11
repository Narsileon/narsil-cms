<?php

namespace App\Http\Resources;

#region USE

use App\Services\TanStackTableService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;
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

        Log::info($pageSize);

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
        return TanStackTableService::getColumns($this->table);
    }

    #endregion
}
