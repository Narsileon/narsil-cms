<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Enums\DataTypeEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterLink;
use Narsil\Models\Globals\FooterSocialMedium;
use Narsil\Models\Sites\Site;
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
                id: Footer::SLUG,
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
                header: ModelService::getTableLabel(Site::TABLE),
                id: Footer::COUNT_WEBSITES,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(FooterLink::TABLE),
                id: Footer::COUNT_LINKS,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(FooterSocialMedium::TABLE),
                id: Footer::COUNT_SOCIAL_MEDIA,
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
