<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Enums\DataTypeEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterSocialLink;
use Narsil\Services\ModelService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Footer::TABLE);
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
                id: Footer::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Footer::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                id: Footer::ADDRESS_LINE_1,
                visibility: false,
            ),
            new TableColumn(
                id: Footer::ADDRESS_LINE_2,
                visibility: false,
            ),
            new TableColumn(
                id: Footer::COMPANY,
                visibility: false,
            ),
            new TableColumn(
                id: Footer::EMAIL,
                visibility: false,
            ),
            new TableColumn(
                id: Footer::PHONE,
                visibility: false,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(FooterSocialLink::TABLE),
                id: Footer::COUNT_SOCIAL_LINKS,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Footer::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Footer::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
