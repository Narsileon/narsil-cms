<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Enums\DataTypeEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Sites\Site;
use Narsil\Services\ModelService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Header::TABLE);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function columns(): array
    {
        return [
            new TableColumn(
                id: Header::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Header::SLUG,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(Site::VIRTUAL_TABLE),
                id: Footer::COUNT_WEBSITES,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Header::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Header::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
