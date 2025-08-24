<?php

namespace Narsil\Support;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TableColumn
{
    #region CONSTRUCTOR

    /**
     * @param string $id
     * @param boolean $visibility
     * @param string|null $accessorKey
     * @param string|null $header
     * @param string|null $type
     *
     * @return void
     */
    public function __construct(
        string $id,
        bool $visibility,
        ?string $accessorKey = null,
        ?string $header = null,
        ?string $type = null,
    )
    {
        $this->accessorKey = $accessorKey;
        $this->header = $header;
        $this->id = $id;
        $this->type = $type;
        $this->visibility = $visibility;
    }

    #endregion

    #region PROPERTIES

    /**
     * The accessor key of the column.
     *
     * @var string|null
     */
    public readonly ?string $accessorKey;

    /**
     * The header of the column.
     *
     * @var string|null
     */
    public readonly ?string $header;

    /**
     * The id of the column.
     *
     * @var string
     */
    public readonly string $id;

    /**
     * The type of the column.
     *
     * @var string|null
     */
    public readonly ?string $type;

    /**
     * The visibility of the column.
     *
     * @var boolean
     */
    public readonly bool $visibility;

    #endregion
}
