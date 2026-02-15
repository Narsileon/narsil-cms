<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Enums\InputTypeEnum;
use Narsil\Base\Http\Data\TanStackTables\ColumnDefData;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Implementations\AbstractTable;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Sites\Site;

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
            new ColumnDefData(
                id: Header::ID,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                id: Header::SLUG,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Site::VIRTUAL_TABLE),
                id: Footer::COUNT_WEBSITES,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                id: Header::CREATED_AT,
                type: InputTypeEnum::DATETIME,
                visibility: true,
            ),
            new ColumnDefData(
                id: Header::UPDATED_AT,
                type: InputTypeEnum::DATETIME,
                visibility: true,
            ),
        ];
    }

    #endregion
}
