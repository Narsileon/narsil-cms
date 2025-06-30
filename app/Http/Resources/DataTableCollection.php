<?php

namespace App\Http\Resources;

#region USE

use App\Services\TableService;
use App\Structures\Column;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Config;
use JsonSerializable;

#endregion

/**
 * @version 1.0.0
 *
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
            $pageIndex,
            ['*'],
            'page',
            $pageSize,
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
     * @param Request $request
     *
     * @return array
     */
    public function with($request): array
    {
        return [
            'columns' => $this->getColumns(),
            'columnVisibility' => $this->getColumnVisiblity(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    protected function getColumns(): array
    {
        $columnDefinitions = TableService::getColumnDefinitions($this->table);

        return $columnDefinitions->map
            ->get()
            ->values()
            ->all();
    }

    /**
     * @return array<string,boolean>
     */
    protected function getColumnVisiblity(): array
    {
        $columnVisibility = [];

        $visible = Config::get("narsil.tables.$this->table", []);

        foreach (TableService::getColumns($this->table) as $columnDefinition)
        {
            $name = $columnDefinition->name;

            $columnVisibility[$name] = in_array($name, $visible);
        }


        return $columnVisibility;
    }

    #endregion
}
