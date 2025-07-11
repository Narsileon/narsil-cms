<?php

namespace App\Http\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;
use JsonSerializable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CategoryCollection extends ResourceCollection
{
    #region CONSTUCTORS

    /**
     * @param mixed $resource
     * @param string $table
     * @param string $label
     *
     * @return void
     */
    public function __construct($resource, string $table, string $label)
    {
        $this->label = $label;
        $this->table = $table;

        parent::__construct($resource);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string
     */
    public const CREATE_HREF = 'create_href';
    /**
     * @var string
     */
    public const EDIT_HREF = 'edit_href';
    /**
     * @var string
     */
    public const DESTROY_HREF = 'destroy_href';
    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const LABEL = 'label';

    #endregion

    #region PROPERTIES

    /**
     * @var string
     */
    protected readonly string $label;
    /**
     * @var string
     */
    protected readonly string $table;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function toArray(Request $request): JsonSerializable
    {
        return $this->collection->map(function ($item)
        {
            return [
                self::ID => $item->id,
                self::LABEL => $item->{$this->label},
                self::EDIT_HREF => route(Str::slug($this->table) . '.edit', $item->id),
                self::DESTROY_HREF => route(Str::slug($this->table) . '.destroy', $item->id),

            ];
        });
    }

    /**
     * {@inheritdoc}
     */
    public function with($request): array
    {
        return [
            'meta' => [
                self::CREATE_HREF => route(Str::slug($this->table) . '.create'),
            ],
        ];
    }

    #endregion
}
