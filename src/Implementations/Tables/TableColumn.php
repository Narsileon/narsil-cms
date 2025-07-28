<?php

namespace Narsil\Tables;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
     * @var string The id of the column.
     */
    public readonly string $id;
    /**
     * @var string|null The accessor key of the column.
     */
    public readonly ?string $accessorKey;
    /**
     * @var string|null The header of the column.
     */
    public readonly ?string $header;
    /**
     * @var string|null The type of the column.
     */
    public readonly ?string $type;
    /**
     * @var boolean The visibility of the column.
     */
    public readonly bool $visibility;

    #endregion
}
